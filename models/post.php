<?php
class post {
    static function get_posts($category=null, $sort=null, $sort_down=true, $skip=0) {
        global $pdo;
        global $forum_id;
        $q = "
            SELECT
              forum.id,
              forum.title,
              category.title AS category,
              forum.author_name,
              forum.author_email_hash,
              forum.replies,
              forum.views,
              forum.stats,
              forum.time_last_activity as last_reply
            FROM forum forum
            LEFT JOIN forum category on category.id = forum.reply_to
        ";
        if ($sort == "people")
            $q .= "
                LEFT JOIN (
                SELECT id, count(*) as contributions
                FROM forum
                GROUP BY author
                ) author ON author.id = forum.author";
        $q .= " WHERE  forum.type = 'post' AND forum.`forum_id` = ? ";
        if ($category)
            $q .= " AND category.id = ? ";

        if ($sort == "title")
            $q .= " ORDER BY title";
        else if ($sort == "views")
            $q .= " ORDER BY forum.views";
        else if ($sort == "replies")
            $q .= " ORDER BY forum.replies";
        else if ($sort == "people")
            $q .= " ORDER BY author.contributions";
        else if ($sort_down)
            $q .= " ORDER BY forum.visibility DESC, forum.time_last_activity ";
        else
            $q .= " ORDER BY forum.time_last_activity ";

        if($sort_down) $q .= " DESC";
        else $q .= " ASC";

        $q .= " LIMIT ?, 60 ";
        $statement = $pdo->prepare($q);

        $inputs = array($forum_id);
        if ($category != null) $inputs[] = $category;
        $inputs[] = $skip;

        $statement->execute($inputs);

        $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($posts as &$post)
            if($post['stats'])
                $post = array_merge(array_combine(self::$post_stat_fields, explode(",", $post['stats'])), $post);
        return $posts;
    }

    static function get_post($post_id, $show_hidden=false) {
        global $pdo;
        global $forum_id;
        $hideq = " AND forum.`visibility` >= 'normal' ";
        if ($show_hidden) $hideq = "";
        $q = "
            SELECT
              forum.`id`,
              forum.`title`,
              forum.`message`,
              forum.`time_created`,
              forum.`author`,
              forum.`author_name`,
              forum.`author_email_hash`,
              replies.reply_num,
              category.title as 'category',
              forum.`visibility`
            FROM forum forum
            LEFT JOIN (
                   SELECT count(*) as reply_num, reply_to
                   FROM forum as replies
                   WHERE replies.`type` = 'reply'
                   AND replies.`forum_id` = ?
                   GROUP BY replies.reply_to
                   ) replies ON id = replies.reply_to
            LEFT JOIN forum category on forum.`reply_to` = category.`id`
            WHERE forum.`type` = 'post'
            AND forum.`forum_id` = ?
            AND forum.`id` = ?
            $hideq
            LIMIT 1
        ";

        $statement = $pdo->prepare($q);
        $statement->execute(array($forum_id, $forum_id, $post_id));
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    static function get_replies($post_id, $skip=0, $show_hidden=false) {
        global $pdo;
        $hideq = " AND forum.`visibility` >= 'normal' ";
        if ($show_hidden) $hideq = "";
        $q = "
            SELECT
              forum.`id`,
              forum.`title`,
              forum.`message`,
              forum.`time_created`,
              forum.`author`,
              forum.`author_name`,
              forum.`author_email_hash`,
              forum.`visibility`
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

    static function get_reply($id) {
        global $pdo;
        global $forum_id;
        $statement = $pdo->prepare("
            SELECT id, author_name, message
            FROM forum
            WHERE id = ?
            AND (type = 'reply'
            OR type = 'post')
            AND visibility >= 'normal'
            AND forum_id = ?
            ");
        $statement->execute(array($id, $forum_id));
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public static function get_simple($id) {
        global $pdo;
        $statement = $pdo->prepare("
            SELECT author, visibility, type
            FROM forum
            WHERE id = ?");
        $statement->execute(array($id));
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public static function add_view($post_id) {
        global $pdo;
        $q = "
          UPDATE forum
          SET forum.`views` = forum.`views` + 1
          WHERE forum.`id` = ?
        ";
        $statement = $pdo->prepare($q);
        $statement->execute(array($post_id));
    }

    public static function new_thread($user_id, $user_name, $user_email_hash, $title, $text, $cat=null)  {
        global $pdo;
        global $forum_id;

        $q = "
            INSERT INTO  `forum` (
                `forum_id` ,
                `type` ,
                `author` ,
                `author_name` ,
                `author_email_hash` ,
                `title`,
                `message`,
                `reply_to`,
                `time_last_activity`
                )
            VALUES (?, 'post', ?, ?, ?, ?, ?, ?, NOW());
        ";

        $statement = $pdo->prepare($q);
        $statement->execute(array($forum_id, $user_id, $user_name, $user_email_hash, $title, $text, $cat));
        return $pdo->lastInsertId();
    }

    public static function post_reply($topic_id, $user_id, $user_name, $user_email_hash, $text)
    {
        global $pdo;
        global $forum_id;
        $q = "
            INSERT INTO  `forum` (
                `forum_id` ,
                `type` ,
                `reply_to` ,
                `author` ,
                `author_name` ,
                `author_email_hash` ,
                `message`
                )
            VALUES (?, 'reply', ?, ?, ?, ?, ?);
        ";

        $statement = $pdo->prepare($q);
        $statement->execute(array($forum_id, $topic_id, $user_id, $user_name, $user_email_hash, $text));
        $post_id = $pdo->lastInsertId();
        self::refresh_post_stats($topic_id);

        return $post_id;
    }

    public static function hide_post($post_id, $recover=false) {
        global $pdo;
        if ($recover) $hide = 'normal';
        else $hide = 'hidden';
        $q = "
            UPDATE forum
            SET visibility = ?
            WHERE id = ?
        ";

        $statement = $pdo->prepare($q);
        $statement->execute(array($hide, $post_id));
        self::refresh_post_stats($post_id, true);
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

    public static function refresh_post_stats($topic_id, $reply=false) {
        global $pdo;
        $q = "
            UPDATE forum forum
            LEFT JOIN (
                 SELECT
                    MAX(id) as last_reply_id,
                    count(*) as reply_num,
                    MAX(time_created) as last_reply_time,
                    reply_to
                FROM forum
                WHERE  `type` =  'reply'
                AND  `visibility` >=  'normal'
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
                    WHERE visibility >= 'normal'
                    GROUP BY author, reply_to
                    ORDER BY replies DESC
                    ) replies_per_author
                GROUP BY replies_per_author.reply_to
            ) most_replies on forum.id = most_replies.reply_to
            SET forum.time_last_activity = replies.last_reply_time,
                forum.replies = replies.reply_num,
                forum.stats = CONCAT_WS(',',
                     last_reply.author_name,
                     last_reply.author_email_hash,
                     most_replies.author_name,
                     most_replies.author_email_hash,
                     most_replies.replies_total)
        ";

        if(!$reply) $q .= ' WHERE forum.id = ?';
        else $q .= ' WHERE forum.id = (SELECT r.reply_to FROM (select reply_to from forum WHERE id = ?) r)';
        $statement = $pdo->prepare($q);
        $statement->execute(array($topic_id));
    }

    public static $post_stat_fields = array (
        "last_replier_name",
        "last_replier_email_hash",
        "most_replies_name",
        "most_replies_email_hash",
        "most_replies_total",
    );
}
