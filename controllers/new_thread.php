<?php

if ($_POST['do'] == 'forum_new_thread') {

    $data = array(
        "title" => htmlentities($_POST['title']),
        "text" => htmlentities($_POST['text']),
        "text_b" => htmlentities($_POST['text_b']),
        "cat" => htmlentities($_POST['cat']),
        "user" => $_SESSION['user_logged_in'],
    );

    if (!$data['text_b'] && strlen($data['text']) > 5) {
        $this->caching = 0;

        if (empty($errors)) {
            //$user_info = users::get($data['user']);
            $post_id = forum::new_thread(
                1,
                "Andy Test",//$user_info['name'],
                "emaillllll",//$user_info['email_hash'],
                $data['title'],
                $data['text'],
                $data['cat']);

            setcookie ("reply_url", "", time() - 3600, "/");
            setcookie ("reply_text", "", time() - 3600, "/");
            //header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
        } else {
            $GLOBALS['cache_id'] = hash("md4", implode("_", $errors)) . "|" . $GLOBALS['cache_id'];
            $this->assign("posterror", true);
            $this->assign("posterrors", $errors);
        }
    }
}