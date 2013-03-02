<?php

if ($_POST['do'] == 'forum_new_thread') {

    $data = array(
        "title" => $_POST['title'],
        "text" => $_POST['text'],
        "text_b" => $_POST['text_b'],
        "cat" => $_POST['category'],
        "user" => $_SESSION['user_logged_in'],
        "user_name" => $_SESSION['user_name'],
        "user_email_hash" => $_SESSION['user_email_hash'],
    );

    if (!$data['text_b'] && strlen($data['text']) > 1) {

        if (empty($errors)) {
            $post_id = forum::new_thread(
                $data['user'],
                $data['user_name'],
                $data['user_email_hash'],
                $data['title'],
                $data['text'],
                $data['cat']);

            $this->clearCache("all_posts");
            $this->clearCache("categories");
            setcookie ("reply_url", "", time() - 3600, "/");
            setcookie ("reply_text", "", time() - 3600, "/");
            header("Location: {$baseurl}/{$post_id}#post${post_id}");
            if (!$GLOBALS['testing']) exit;
        } else {
            $this->addCacheId(hash("md4", implode("_", $errors)));
            $this->assign("posterror", true);
            $this->assign("posterrors", $errors);
        }
    }
}