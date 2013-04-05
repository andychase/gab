<?php

if ($_COOKIE['PHPSESSID']) {
    session_set_cookie_params(999999);
    session_start();
    if ($_SESSION['user_logged_in']) {
        global $forum_id;
        // Fixes a security problem if a user copies over the php session id
        if ($forum_id != $_SESSION['forum_id']) exit;
        $gab->prepare_user(
            $_SESSION['user_logged_in'],
            $_SESSION['user_name'],
            $_SESSION['user_email_hash'],
            $_SESSION['badges']
        );
    }
}