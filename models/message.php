<?php

class message {
    public static function get_messages($user_name) {
        global $pdo;
        global $forum_id;
        $q = '
            SELECT mention.type, mention.reply_to, mention.id, mention.author_name, mention.message, mention.time_created, category.title
            FROM forum mention
            LEFT JOIN forum category on mention.reply_to = category.id
            WHERE mention.message LIKE ?
            AND mention.forum_id = ?
            AND mention.visibility >= "normal"

            UNION

            SELECT mention.type, mention.reply_to, mention.id, mention.author_name, mention.message, mention.time_created, category.title
            FROM forum mention
            LEFT JOIN forum category on mention.reply_to = category.id
            WHERE mention.message LIKE ?
            AND mention.forum_id = ?
            AND mention.visibility >= "normal"

            UNION

            SELECT mention.type, mention.reply_to, mention.id, mention.author_name, mention.message, mention.time_created, category.title
            FROM forum mention
            LEFT JOIN forum category on mention.reply_to = category.id
            WHERE mention.message LIKE ?
            AND mention.forum_id = ?
            AND mention.visibility >= "normal"

            UNION

            SELECT mention.type, mention.reply_to, mention.id, mention.author_name, mention.message, mention.time_created, category.title
            FROM forum mention
            LEFT JOIN forum category on mention.reply_to = category.id
            WHERE mention.message LIKE ?
            AND mention.forum_id = ?
            AND mention.visibility >= "normal"

            ORDER BY time_created DESC
            ';
        $statement = $pdo->prepare($q);

        $inputs = array();
        $inputs[] = "@${user_name}\r\n%";
        $inputs[] = $forum_id;
        $inputs[] = "@${user_name}\n%";
        $inputs[] = $forum_id;
        $inputs[] = "@${user_name}:%";
        $inputs[] = $forum_id;
        $inputs[] = "@${user_name} %";
        $inputs[] = $forum_id;

        $statement->execute($inputs);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}