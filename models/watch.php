<?php

class watch {
    static function get_unread($user_id) {
        global $pdo;
        $q = "
            SELECT post.id, post.title, post.message
            FROM forum watching
            LEFT JOIN forum post on post.id = watching.reply_to
            WHERE watching.type = 'watch'
            AND watching.author = ?
            AND (
             post.time_last_activity > watching.time_last_activity
             OR
             coalesce(post.replies, 0) > coalesce(watching.replies, 0)
            )
        ";
        $statement = $pdo->prepare($q);
        $statement->execute(array($user_id));
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    static function read($author, $topic_id) {
        global $pdo;
        $q = "
            UPDATE forum watching LEFT JOIN forum post on post.id = watching.reply_to
            SET
              watching.time_last_activity = post.time_last_activity,
              watching.replies = post.replies
            WHERE post.id = ?
            AND watching.author = ?
        ";
        $statement = $pdo->prepare($q);
        return $statement->execute(array($topic_id, $author));
    }

    static function new_watch($topic_id, $author, $author_name, $author_email_hash) {
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
                `time_last_activity`,
                `replies`
                )
            VALUES (?,  'watch',  ?,  ?,  ?,  ?, NOW(), (select * from (select replies from forum where id = ?) f));
        ";
        $statement = $pdo->prepare($q);
        $statement->execute(array($forum_id, $topic_id, $author, $author_name, $author_email_hash, $topic_id));
        return $pdo->lastInsertId();
    }

}