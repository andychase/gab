<?php
if ($_POST['do'] == 'forum_new_thread') {

    $data = array(
        "author" => $_SESSION['user_logged_in'],
        "author_name" => $_SESSION['user_name'],
        "author_email_hash" => $_SESSION['user_email_hash'],
        "title" => $_POST['title'],
        "message" => $_POST['text'],
        "category" => $_POST['category'],
        "spam" => $_POST['text_b'],
    );

    if (!$data['spam'] && strlen($data['message']) > 1) {

        if (empty($errors)) {
            $post_id = post::new_thread(
                $data['author'],
                $data['author_name'],
                $data['author_email_hash'],
                $data['title'],
                $data['message'],
                $data['cat']);

            $this->triggerPostChangedCallback($post_id);

            $this->clearCache("posts");
            $this->clearCache("categories");
            $this->clearCache('single_user', $data['author_name']);

            // Clear saved draft data
            setcookie ("reply_url", "", time() - 3600, "/");
            setcookie ("reply_text", "", time() - 3600, "/");

            // Redirect to new post
            header("Location: {$baseurl}/{$post_id}#post${post_id}");
            if (!$GLOBALS['testing']) exit;
        } else {
            $this->addCacheId(hash("md4", implode("_", $errors)));
            $this->assign("posterror", true);
            $this->assign("posterrors", $errors);
        }
    }
}