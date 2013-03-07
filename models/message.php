<?php

class message {
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
}