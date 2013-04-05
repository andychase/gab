<?php

class user {
    static function get_user($user_id=null, $user_name=null, $user_title=null) {
        global $pdo;
        global $forum_id;

        $find_by_item = $user_id . $user_name . $user_title;
        if ($user_id)
            $find_by = ' WHERE id = ?';
        else if ($user_name)
            $find_by = ' WHERE author_name = ?';
        else if ($user_title)
            $find_by = ' WHERE title = ?';
        else
            return null;

        $q = "
             SELECT id, `time_created`, author_name, author_email_hash, visibility, badges, ext
             FROM forum user
             $find_by
             AND type = 'user'
             AND forum_id = ?
             LIMIT 1
         ";
        $statement = $pdo->prepare($q);
        $statement->execute(array($find_by_item, $forum_id));
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            if(strlen($user['badges']))
                $user['badges'] = explode(',', $user['badges']);
            else
                $user['badges'] = array();
        }
        return $user;
    }

    public static function get_user_posts($user_id) {
        global $pdo;
        $q = "
            SELECT
             post.`id`,
             post.`reply_to`,
             post.`title`,
             post.`time_last_activity`,
             post.`visibility`, post.`type`, post.`message`
            FROM forum post
            WHERE (post.`type` = 'post'
            OR post.`type` = 'reply')
            AND post.`author` = ?
            AND visibility >= 'normal'

            ORDER BY id DESC
            LIMIT 0, 10
        ";
        $statement = $pdo->prepare($q);
        $statement->execute(array($user_id));
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    static function get_user_ext($user_id) {
        global $pdo;
        $statement = $pdo->prepare("SELECT ext from forum where id = ?");
        $statement->execute(array($user_id));
        return unserialize($statement->fetchColumn());
    }

    static function get_user_ext_lock($user_id) {
        /* The locking mechanism is in place to prevent a race condition data loss
            1. Thread 1 reads 'a'
            2. Thread 2 reads 'a'
            3. Thread 1 sets 'a:1'
            4. Thread 2 sets 'a,b:3'
            5. Thread 1's data was lost.
        If you are saving any ext data, you must call this method to get the current state first.
        If are only reading, you can use the other method..
        */
        global $pdo;
        if (!$GLOBALS['testing']) $pdo->beginTransaction();
        $statement = $pdo->prepare("SELECT ext from forum where id = ? FOR UPDATE");
        $statement->execute(array($user_id));
        return unserialize($statement->fetchColumn());
    }

    static function set_user_ext($user_id, $ext) {
        global $pdo;
        $statement = $pdo->prepare("UPDATE forum SET ext = ? where id = ?");
        $result = $statement->execute(array(serialize($ext), $user_id));
        if (!$GLOBALS['testing']) $pdo->commit();
        return $result;
    }

    static function new_user($user_title, $user_name, $user_email_hash) {
        global $pdo;
        global $forum_id;
        $q = "
            INSERT INTO  `forum` (
                `forum_id` ,
                `title` ,
                `author_name` ,
                `author_email_hash` ,
                `type`
                )
            VALUES (?, ?, ?, ?, 'user');
        ";

        $statement = $pdo->prepare($q);
        $statement->execute(array($forum_id, $user_title, $user_name, $user_email_hash));
        return $pdo->lastInsertId();
    }

    public static function just_inserted_first_user() {
        global $pdo;
        global $forum_id;
        $statement = $pdo->prepare("
            SELECT id
            FROM forum
            WHERE type = 'user'
            AND id != ?
            AND forum_id = ?
        ");
        $statement->execute(array($pdo->lastInsertId(), $forum_id));
        return !$statement->fetchAll();
    }

    public static function get_users() {
        global $pdo;
        global $forum_id;
        $q = "
            SELECT author, author_name, author_email_hash, ext
            FROM forum
            WHERE type = 'user'
            AND forum_id = ?
            AND visibility >= 'normal'
            LIMIT 300
        ";
        $statement = $pdo->prepare($q);
        $statement->execute(array($forum_id));
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function exists_user_name($name) {
        global $pdo;
        global $forum_id;
        $statement = $pdo->prepare("
            SELECT id
            FROM forum
            WHERE author_name = ?
            AND forum_id = ?
            LIMIT 1
        ");
        $statement->execute(array($name, $forum_id));
        return $statement->fetchAll();
    }

    public static function add_badge($user_id, $badge) {
        global $pdo;
        $statement = $pdo->prepare("
            UPDATE forum
            SET badges = CONCAT_WS(',', badges, ?)
            WHERE id = ?
        ");
        return $statement->execute(array($badge, $user_id));
    }

    public static function remove_badge($user_id, $badge) {
        global $pdo;
        $statement = $pdo->prepare("
            UPDATE forum
            SET badges = REPLACE(REPLACE(REPLACE(badges, ?, ''), ?, ''), ?, '')
            WHERE id = ?
        ");
        return $statement->execute(array(','.$badge, $badge.',', $badge, $user_id));
    }

    public static function ban($user_id, $recover=false) {
        global $pdo;
        if ($recover) $hide = 'normal';
        else $hide = 'hidden';
        $q = "
            UPDATE forum
            SET visibility = ?
            WHERE id = ?
        ";

        $statement = $pdo->prepare($q);
        $statement->execute(array($hide, $user_id));
    }

    public static function change_email_hash($author_id, $new_email_hash) {
        global $pdo;
        $statement = $pdo->prepare("
            UPDATE forum
            SET author_email_hash = ?
            WHERE author = ?
        ");
        return $statement->execute(array($new_email_hash, $author_id));
    }
}