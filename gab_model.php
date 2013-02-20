<?php

class forum {

    static function get_posts() {
        global $pdo;

        $q = "
            SELECT  forum.`id`,
                    forum.`title`,
                    category.`title` as category,
                    forum.`author_name`,
                    forum.`author_email_hash`,
                    replies.reply_num as replies,
                    forum.`views`,
                    replies.last_reply as last_reply
            FROM forum forum
            LEFT JOIN (
                   SELECT count(*) as reply_num, MAX(replies.`timestamp`) as last_reply, replies.reply_to
                   FROM forum as replies
                   WHERE replies.`type` = 'reply'
                   GROUP BY replies.reply_to
                   ) replies ON id = replies.reply_to
            LEFT JOIN forum category on forum.`reply_to` = category.`id`
            WHERE forum.`type` = 'post'
        ";

        $statement = $pdo->prepare($q);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    static function get_post($post_id) {
        global $pdo;
        $q = "
            SELECT
              forum.`id`,
              forum.`title`,
              forum.`message`,
              forum.`timestamp`,
              forum.`author_name`,
              forum.`author_email_hash`,
              replies.number_of_replies as replies,
              category.title as 'category'
            FROM forum forum
            LEFT JOIN (
                   SELECT count(*) as number_of_replies, replies.reply_to
                   FROM forum as replies
                   WHERE replies.`type` = 'reply'
                   GROUP BY replies.reply_to
                   ) replies ON id = replies.reply_to
            LEFT JOIN forum category on forum.`reply_to` = category.`id`
            WHERE forum.`type` = 'post'
            AND forum.`id` = ?
            LIMIT 1
        ";

        $statement = $pdo->prepare($q);
        $statement->execute(array($post_id));
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    static function get_replies($post_id, $skip=0) {
        global $pdo;
        $q = "
            SELECT
              forum.`id`,
              forum.`title`,
              forum.`message`,
              forum.`timestamp`,
              forum.`author_name`,
              forum.`author_email_hash`
            FROM forum forum
            WHERE forum.`type` = 'reply'
            AND forum.`reply_to` = ?
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

    public static function new_category($author, $author_name, $author_email_hash, $title, $description)
    {
        global $pdo;
        $q = "
            INSERT INTO  `forum` (
                `type` ,
                `author` ,
                `author_name` ,
                `author_email_hash` ,
                `title`,
                `message`,
                `reply_to`,
                `latest`
                )
            VALUES ('category', ?, ?, ?, ?, ?, NULL, 'Y');
        ";
        $statement = $pdo->prepare($q);
        $statement->execute(array($author, $author_name, $author_email_hash, $title, $description));
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
                `message` ,
                `latest`
                )
            VALUES ('reply', ?, ?, ?, ?, ?, 'Y');
        ";

        $statement = $pdo->prepare($q);
        $statement->execute(array($topic_id, $user_id, $user_name, $user_email_hash, $text));
        return $pdo->lastInsertId();
    }

    public static function new_thread($user_id, $user_name, $user_email_hash, $title, $text, $cat=null)
    {
        global $pdo;

        if (empty($cat)) $cat = null;

        $q = "
            INSERT INTO  `forum` (
                `type` ,
                `author` ,
                `author_name` ,
                `author_email_hash` ,
                `title`,
                `message`,
                `reply_to`,
                `latest`
                )
            VALUES ('post', ?, ?, ?, ?, ?, ?, 'Y');
        ";

        $statement = $pdo->prepare($q);
        $statement->execute(array($user_id, $user_name, $user_email_hash, $title, $text, $cat));
        return $pdo->lastInsertId();
    }

    public static function get_messages($user_name) {
        global $pdo;
        $q = "
            SELECT mention.type, mention.reply_to, mention.id, mention.author_name, mention.message, mention.timestamp, category.title
            FROM forum mention
            LEFT JOIN forum category on mention.reply_to = category.id
            WHERE mention.message LIKE ?
            UNION
            SELECT mention.type, mention.reply_to, mention.id, mention.author_name, mention.message, mention.timestamp, category.title
            FROM forum mention
            LEFT JOIN forum category on mention.reply_to = category.id
            WHERE mention.message LIKE ?
            UNION
            SELECT mention.type, mention.reply_to, mention.id, mention.author_name, mention.message, mention.timestamp, category.title
            FROM forum mention
            LEFT JOIN forum category on mention.reply_to = category.id
            WHERE mention.message LIKE ?
            ORDER BY timestamp DESC
            ";
        $statement = $pdo->prepare($q);
        $statement->execute(array("@${user_name}\r\n%", "@${user_name}\n%", "@${user_name} %"));
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    static function get_post_category($category_id) {
        global $pdo;
        $q = "
            SELECT  forum.`id`,
                    forum.`title`,
                    replies.reply_num as replies,
                    replies.last_reply as last_reply
            FROM forum forum
            LEFT JOIN (
                   SELECT count(*) as reply_num, MAX(replies.`timestamp`) as last_reply, replies.reply_to
                   FROM forum as replies
                   WHERE replies.`type` = 'reply'
                   GROUP BY replies.reply_to
                   ) replies ON id = replies.reply_to
            WHERE forum.`type` = 'post'
            AND forum.reply_to ";
        if ($category_id == "") $q .= "is null";
        else $q .= "= ?";

        $statement = $pdo->prepare($q);
        if ($category_id == null) $statement->execute();
        else $statement->execute(array($category_id));
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    static function get_categories() {
        global $pdo;

        $q = "
            SELECT category.id, category.title, category.message, posts.number_of_posts
            FROM forum category
            LEFT JOIN (
              SELECT posts.reply_to, count(*) as number_of_posts
              FROM forum posts
              WHERE posts.type = 'post'
              GROUP BY reply_to
            ) posts on posts.reply_to = category.id
            WHERE category.`type` = 'category'
            ORDER BY posts.number_of_posts DESC
        ";

        $statement = $pdo->prepare($q);
        $statement->execute();
        $categories = $statement->fetchAll(PDO::FETCH_ASSOC);
        $categories[''] = array("id" => "", "title" => "", "message" => "");
        foreach ($categories as $id => $category) {
            $categories[$id]['posts'] = self::get_post_category($category['id']);
        }
        return $categories;
    }
}