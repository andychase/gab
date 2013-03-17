<?php

class watch {
    function get_user_watching($user_id) {
        global $pdo;
        $q = "
            SELECT post.title, post.message
            FROM forum watching
            WHERE watching.type = 'watch'
            AND watching.author = ?
            AND post.time_last_activity > watching.time_last_activity
            LEFT JOIN forum post on post.id = watching.reply_to
        ";
        $statement = $pdo->prepare($q);
        return $statement->execute(array($user_id));
    }

    function update_watched($author, $topic_id) {
        global $pdo;
        $q = "
            UPDATE forum watching LEFT JOIN forum post on post.id = watching.reply_to
            SET watching.time_last_activity = post.time_last_activity
            WHERE post.id = ?
            AND watching.author = ?
        ";
        $statement = $pdo->prepare($q);
        return $statement->execute(array($topic_id, $author));
    }

    function new_watching($topic_id, $author, $author_name, $author_email_hash) {
        global $pdo;
        global $forum_id;
        $q = "
            INSERT INTO  `forum` (
                `forum_id` ,
                `type` ,
                `reply_to` ,
                `author` ,
                `author_email_hash` ,
                `author_name` ,
                `time_last_activity`
                )
            VALUES (?,  'watch',  ?,  ?,  ?,  ?, NOW());
        ";
        $statement = $pdo->prepare($q);
        $statement->execute(array($forum_id, $topic_id, $author, $author_name, $author_email_hash));
        return $pdo->lastInsertId();
    }

}