<?php
class post {
    static function get_posts($category=null, $sort=null, $sort_down=true, $show_hidden=false) {
        global $pdo;
        $q = "
            SELECT
              forum.id,
              forum.title,
              category.title AS category,
              forum.author_name,
              forum.author_email_hash,
              forum.views,
              Coalesce(replies.last_reply, forum.timestamp) AS last_reply,
              last_reply.author_name as last_replier_name,
              last_reply.author_email_hash as last_replier_email_hash,
              most_replies.replies_total as most_replies_total,
              most_replies.author_name as most_replies_name,
              most_replies.author_email_hash as most_replies_email_hash,
              replies.reply_num as replies
            FROM forum forum
            LEFT JOIN (
                 SELECT
                    count(*) as reply_num,
                    max(`timestamp`) AS last_reply,
                    max(`id`) AS last_reply_id,
                    reply_to
                FROM forum
                WHERE  `type` =  'reply'
                AND  `status` >=  'normal'
                GROUP BY reply_to
            ) replies ON forum.id = replies.reply_to
            LEFT JOIN forum category ON forum.reply_to = category.id
            LEFT JOIN forum last_reply ON replies.last_reply_id = last_reply.id
            LEFT JOIN (
                SELECT
                  replies_per_author.author_name,
                  replies_per_author.author_email_hash,
                  max(replies_per_author.replies) as replies_total,
                  replies_per_author.reply_to
                FROM (
                    SELECT author_name, author_email_hash, count(*) as replies, reply_to
                    FROM forum
                    WHERE status >= 'normal'
                    GROUP BY author, reply_to
                    ORDER BY replies DESC
                    ) replies_per_author
                GROUP BY replies_per_author.reply_to
            ) most_replies on forum.id = most_replies.reply_to
        ";
        if ($sort == "people")
            $q .= "
                LEFT JOIN (
                SELECT id, count(*) as contributions
                FROM forum
                GROUP BY author
                ) author ON author.id = forum.author";


        $q .= " WHERE  forum.type = 'post' ";
        if ($category)
            $q .= " AND category.title = ? ";
        $q .= " AND forum.`status` >= 'normal' ";

        if ($sort == "category")
            $q .= " ORDER BY - RAND() * LOG((NOW() - forum.timestamp))";
        else if ($sort == "title")
            $q .= " ORDER BY title";
        else if ($sort == "views")
            $q .= " ORDER BY forum.views";
        else if ($sort == "replies")
            $q .= " ORDER BY replies.reply_num";
        else if ($sort == "people")
            $q .= " ORDER BY author.contributions";
        else
            $q .= " ORDER BY last_reply";

        if($sort_down) $q .= " DESC";
        else $q .= " ASC";

        $statement = $pdo->prepare($q);

        if ($category == null) $statement->execute();
        else $statement->execute(array($category));

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    static function get_post($post_id, $show_hidden=false) {
        global $pdo;
        $hideq = " AND forum.`status` >= 'normal' ";
        if ($show_hidden) $hideq = "";
        $q = "
            SELECT
              forum.`id`,
              forum.`title`,
              forum.`message`,
              forum.`timestamp`,
              forum.`author`,
              forum.`author_name`,
              forum.`author_email_hash`,
              replies.reply_num,
              category.title as 'category',
              forum.`status`
            FROM forum forum
            LEFT JOIN (
                   SELECT count(*) as reply_num, reply_to
                   FROM forum as replies
                   WHERE replies.`type` = 'reply'
                   GROUP BY replies.reply_to
                   ) replies ON id = replies.reply_to
            LEFT JOIN forum category on forum.`reply_to` = category.`id`
            WHERE forum.`type` = 'post'
            AND forum.`id` = ?
            $hideq
            LIMIT 1
        ";

        $statement = $pdo->prepare($q);
        $statement->execute(array($post_id));
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    static function get_replies($post_id, $skip=0, $show_hidden=false) {
        global $pdo;
        $hideq = " AND forum.`status` >= 'normal' ";
        if ($show_hidden) $hideq = "";
        $q = "
            SELECT
              forum.`id`,
              forum.`title`,
              forum.`message`,
              forum.`timestamp`,
              forum.`author`,
              forum.`author_name`,
              forum.`author_email_hash`,
              forum.`status`
            FROM forum forum
            WHERE forum.`type` = 'reply'
            AND forum.`reply_to` = ?
            $hideq
            ORDER BY forum.`id` ASC
            LIMIT ?, 60
        ";

        $statement = $pdo->prepare($q);
        $statement->execute(array($post_id, $skip));

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function add_view($post_id)
    {
        global $pdo;
        $q = "
          UPDATE forum
          SET forum.`views` = forum.`views` + 1
          WHERE forum.`id` = ?
        ";
        $statement = $pdo->prepare($q);
        $statement->execute(array($post_id));
    }

    public static function new_thread($user_id, $user_name, $user_email_hash, $title, $text, $cat=null)
    {
        global $pdo;

        if ($cat) {
            $statement = $pdo->prepare("
                SELECT id FROM forum WHERE type = 'category' AND title = ?
            ");
            $statement->execute(array($cat));
            $cat = $statement->fetchColumn();
        } else {
            $cat = null;
        }

        $q = "
            INSERT INTO  `forum` (
                `type` ,
                `author` ,
                `author_name` ,
                `author_email_hash` ,
                `title`,
                `message`,
                `reply_to`
                )
            VALUES ('post', ?, ?, ?, ?, ?, ?);
        ";

        $statement = $pdo->prepare($q);
        $statement->execute(array($user_id, $user_name, $user_email_hash, $title, $text, $cat));
        return $pdo->lastInsertId();
    }

    public static function post_reply($topic_id, $user_id, $user_name, $user_email_hash, $text)
    {
        global $pdo;
        $q = "
            INSERT INTO  `forum` (
                `type` ,
                `reply_to` ,
                `author` ,
                `author_name` ,
                `author_email_hash` ,
                `message`
                )
            VALUES ('reply', ?, ?, ?, ?, ?);
        ";

        $statement = $pdo->prepare($q);
        $statement->execute(array($topic_id, $user_id, $user_name, $user_email_hash, $text));
        return $pdo->lastInsertId();
    }

    public static function get_author($id) {
        global $pdo;
        $statement = $pdo->prepare("
            SELECT author
            FROM forum
            WHERE id = ?");
        $statement->execute(array($id));
        return $statement->fetchColumn();
    }


    public static function hide_post($post_id, $recover=false) {
        global $pdo;
        if ($recover) $hide = 'normal';
        else $hide = 'hidden';
        $q = "
            UPDATE forum
            SET status = ?
            WHERE id = ?;
        ";
        $statement = $pdo->prepare($q);
        return $statement->execute(array($hide, $post_id));
    }

    public static function modify_post($post_id, $text) {
        global $pdo;
        $q = "
            UPDATE forum
            SET message = ?
            WHERE id = ?
        ";
        $statement = $pdo->prepare($q);
        return $statement->execute(array($text, $post_id));
    }
}
