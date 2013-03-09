<?php

class category {
    static function get_post_category($category_id) {
        global $pdo;
        $q = '
            SELECT  forum.`id`,
                    forum.`title`,
                    replies.reply_num as replies,
                    COALESCE(replies.last_reply, forum.time_created) as last_reply
            FROM forum forum
            LEFT JOIN
                (
                   SELECT count(*) as reply_num,
                          MAX(replies.`time_created`) as last_reply,
                          replies.reply_to
                   FROM forum replies
                   WHERE replies.`type` = "reply"
                   AND replies.`status` >= "normal"
                   GROUP BY replies.reply_to
               )  replies ON id = replies.reply_to
            WHERE forum.`type` = "post"
            AND forum.`status` >= "normal"
            AND forum.reply_to
            ';

        if ($category_id == "") $q .= "is null";
        else $q .= "= ?";

        $q .= " ORDER BY last_reply DESC";

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
              AND status >= 'normal'
              GROUP BY reply_to

            ) posts on posts.reply_to = category.id
          WHERE category.type = 'category'
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

    static function get_category_list() {
        global $pdo;
        $statement = $pdo->prepare("SELECT id, title FROM forum WHERE type = 'category'");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    static function get_category($id) {
        global $pdo;
        $statement = $pdo->prepare("SELECT title FROM forum WHERE type = 'category' and id = ?");
        $statement->execute(array($id));
        return $statement->fetchAll(PDO::FETCH_ASSOC);
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
                `reply_to`
                )
            VALUES ('category', ?, ?, ?, ?, ?, NULL);
        ";
        $statement = $pdo->prepare($q);
        $statement->execute(array($author, $author_name, $author_email_hash, $title, $description));
        return $pdo->lastInsertId();
    }
}