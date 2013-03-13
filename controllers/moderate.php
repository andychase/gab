<?php

if (($_GET['delete'] || $_GET['recover'] || $_POST['edit']) && count($matches) > 0) {
    $post_id = intval($_GET['delete'] . $_GET['recover'] . $_POST['edit']);
    // Todo: Check if post status is higher than hidden before allowing a recover/edit
    $user_is_author = (post::get_author($post_id) == $_SESSION['user_logged_in']);
    if ($user_is_author || $this->hasPermission('delete')) {
        if ($_GET['recover'])
            post::hide_post($_GET['recover'], true);
        else if ($_GET['delete'])
            post::hide_post($_GET['delete']);
        else if ($_POST['edit']) {
            post::modify_post($post_id, $_POST['text']);
            header("location: ./");
        }
        $this->clearCache('single_post', $matches[1]);
        $this->clearCache('posts');
        $this->clearCache('categories');
        $this->clearCache('messages');
    }
}