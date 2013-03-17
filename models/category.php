<?php

class category {
    static function get_post_category($category_id) {
        global $pdo;
        global $forum_id;
        $q = '
            SELECT  `id`,
                    `title`,
                    replies,
                    time_last_activity as last_reply
            FROM forum
            WHERE type = "post"
            AND forum_id = ?
            AND reply_to
            ';

        if ($category_id == "") $q .= "is null";
        else $q .= "= ?";

        $q .= " ORDER BY visibility DESC, time_last_activity DESC
                LIMIT 0, 5";

        $statement = $pdo->prepare($q);
        if ($category_id == null) $statement->execute(array($forum_id));
        else $statement->execute(array($forum_id, $category_id));
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    static function get_categories() {
        global $pdo;
        global $forum_id;
        $q = "
          SELECT category.id, category.title, category.message
          FROM forum category
          WHERE category.type = 'category'
          AND forum_id = ?
        ";
        $statement = $pdo->prepare($q);
        $statement->execute(array($forum_id));
        $categories = $statement->fetchAll(PDO::FETCH_ASSOC);

        $categories[''] = array("id" => "", "title" => "", "message" => "");
        foreach ($categories as $id => $category) {
            $categories[$id]['posts'] = self::get_post_category($category['id']);
        }
        return $categories;
    }

    static function get_category_list() {
        global $pdo;
        global $forum_id;
        $statement = $pdo->prepare("
            SELECT id, title
            FROM forum
            WHERE type = 'category'
            AND forum_id = ?");
        $statement->execute(array($forum_id));
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    static function get_category($id) {
        global $pdo;
        $statement = $pdo->prepare("SELECT title FROM forum WHERE type = 'category' and id = ?");
        $statement->execute(array($id));
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    static function get_category_id($title) {
        global $pdo;
        global $forum_id;
        $statement = $pdo->prepare("
            SELECT id
            FROM forum
            WHERE type = 'category'
            AND forum_id = ?
            AND title = ?");
        $statement->execute(array($forum_id, $title));
        return $statement->fetchColumn();
    }

    public static function new_category($author, $author_name, $author_email_hash, $title, $description)
    {
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
                `reply_to`
                )
            VALUES (?, 'category', ?, ?, ?, ?, ?, NULL);
        ";
        $statement = $pdo->prepare($q);
        $statement->execute(array($forum_id, $author, $author_name, $author_email_hash, $title, $description));
        return $pdo->lastInsertId();
    }
}