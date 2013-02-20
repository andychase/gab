<?php


$data = array(
    "text" => htmlentities($_POST['text']),
    "topic_id" => htmlentities($_POST['topic_id']),
    "text_b" => htmlentities($_POST['text_b']),
    "user" => $_SESSION['user_logged_in'],
);

if (!$data['text_b'] && $data['text'] && $data['topic_id']) {

    $this->caching = 0;

    //$errors = validateFields($data, $validators);
    if (empty($errors)) {
        $post_id = forum::post_reply(
            $data['topic_id'],
            0,//$data['user'],
            "asdf",//$user_info['name'],
            "asdfasdf",//$user_info['email_hash'],
            $data['text']);

        $this->clearCache('forum/post.tpl', $data['topic_id']);
        setcookie ("reply_url", "", time() - 3600, "/");
        setcookie ("reply_text", "", time() - 3600, "/");
        //header("Location: http://${GLOBALS['BASEURL']}/forum/${data['topic_id']}#post${post_id}");
        //if (!$GLOBALS['testing']) exit;
    } else {
        $GLOBALS['cache_id'] = hash("md4", implode("_", $errors)) . "|" . $GLOBALS['cache_id'];
        $this->assign("posterror", true);
        $this->assign("posterrors", $errors);
    }
}

