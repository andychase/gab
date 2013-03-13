<?php

if (($_GET['delete'] || $_GET['recover'] || $_POST['edit']) && count($matches) > 0) {

    // Get information about the post
    $post_id = intval($_GET['delete'] . $_GET['recover'] . $_POST['edit']);
    $post = post::get_simple($post_id);
    $user_is_author = ($post['author'] == $_SESSION['user_logged_in']);

    if ($this->hasPermission('delete') || ($user_is_author && $post['status'] == "normal")) {
        if ($_GET['recover'])
            post::hide_post($post_id, true);
        else if ($_GET['delete'])
            post::hide_post($post_id);
        else if ($_POST['edit'])
            post::modify_post($post_id, $_POST['text']);

        $this->triggerPostChangedCallback($post_id);

        $this->clearCache('single_post', $matches[1]);
        $this->clearCache('posts');
        $this->clearCache('categories');
        $this->clearCache('messages');

        header("location: ./");
        if (!$GLOBALS['testing']) exit;
    }
}