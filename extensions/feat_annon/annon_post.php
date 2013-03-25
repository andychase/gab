<?php

if(!$this->user->id) {
    $email = $_POST['email'];
    if(!$email) $email = md5($_SERVER['REMOTE_ADDR']);

    $data = array(
        "reply_to" => $_POST['topic_id'],
        "author" => null,
        "author_name" => htmlentities($POST['name']),
        "author_email_hash" => $email,
        "message" => $_POST['text'],
        "spam" => $_POST['text_b'],
    );
    $allow_anonymous = true;
}