<?php

if ($_COOKIE['PHPSESSID']) {
    session_set_cookie_params(0);
    session_start();
    if ($_SESSION['user_logged_in']) {
        $this->prepare_user(
            $_SESSION['user_logged_in'],
            $_SESSION['user_name'],
            $_SESSION['user_email_hash'],
            $_SESSION['badges']
        );
    }
}