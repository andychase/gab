<?php

class category {
    static function get_post_category($category_id) {
        global $pdo;
        $q = '
            SELECT  `id`,
                    `title`,
                    replies,
                    time_last_activity as last_reply
            FROM forum
            WHERE type = "post"
            AND reply_to
            ';

        if ($category_id == "") $q .= "is null";
        else $q .= "= ?";

        $q .= " ORDER BY status DESC, time_last_activity DESC
                LIMIT 0, 5";

        $statement = $pdo->prepare($q);
        if ($category_id == null) $statement->execute();
        else $statement->execute(array($category_id));
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    static function get_categories() {
        global $pdo;
        $q = "
          SELECT category.id, category.title, category.message
          FROM forum category
          WHERE category.type = 'category'
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

    static function get_category_id($title) {
        global $pdo;
        $statement = $pdo->prepare("SELECT id FROM forum WHERE type = 'category' and title = ?");
        $statement->execute(array($title));
        return $statement->fetchColumn();
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