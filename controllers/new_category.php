<?php

if ($_POST['do'] == 'forum_new_category' && $_SESSION['user_trust'] >= $this->trust_levels['new_category']) {

    $data = array(
        "title" => htmlentities($_POST['title']),
        "text" => htmlentities($_POST['description']),
        "text_b" => htmlentities($_POST['text_b']),
        "user" => $_SESSION['user_logged_in'],
        "user_name" => $_SESSION['user_name'],
        "user_email_hash" => $_SESSION['user_email_hash'],
    );

    if (!$data['text_b'] && strlen($data['title']) > 0) {
        $this->caching = 0;

        if (empty($errors)) {
            $post_id = forum::new_category(
                $data['user'],
                $data['user_name'],
                $data['user_email_hash'],
                $data['title'],
                $data['text']
                );

            $this->clearCache("categories");
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