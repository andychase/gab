<?php

if (!$data) $data = array(
    "reply_to" => $_POST['topic_id'],
    "author" => $_SESSION['user_logged_in'],
    "author_name" => $_SESSION['user_name'],
    "author_email_hash" => $_SESSION['user_email_hash'],
    "message" => $_POST['text'],
    "spam" => $_POST['text_b'],
);

if (!$data['spam'] && $data['message'] && $data['reply_to'] && ($data['author'] || $allow_anonymous)) {
    $this->caching = 0;

    //$errors = validateFields($data, $validators);
    if (empty($errors)) {

        $post_id = post::post_reply(
            $data['reply_to'],
            $data['author'],
            $data['author_name'],
            $data['author_email_hash'],
            $data['message']);

        $this->trigger('post_reply', $post_id);

        $this->clearCache('posts');
        $this->clearCache('single_post', $data['reply_to']);
        $this->clearCache('single_user', $data['author_name']);
        if($data['message'][0] == "@")
            $this->clearCache('single_user', substr($data['message'], 1, strpos($data['message'], ":")-1));

        // Clear saved draft data
        setcookie ("reply_url", "", time() - 3600, "/");
        setcookie ("reply_text", "", time() - 3600, "/");

        // Redirect to new reply
        header("Location: {$baseurl}/${data['reply_to']}#post${post_id}");
        $this->redirect = true;
    } else {
        $this->addCacheId(hash("md4", implode("_", $errors)));
        $this->assign("posterror", true);
        $this->assign("posterrors", $errors);
    }
}

