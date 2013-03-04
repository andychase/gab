<?php

if (($_GET['delete'] || $_GET['recover']) && count($matches) > 0) {
    $post_id = $matches[1];
    $user_deletion = forum::get_author($post_id) == $_SESSION['user_logged_in'];
    if ($user_deletion || $this->hasPermission('delete')) {
        if (!empty($_GET['recover']))
            forum::hide_post($_GET['recover'], true);
        else
            forum::hide_post($_GET['delete']);
        $this->clearCache('single_post', $post_id);
        $this->clearCache('posts');
        $this->clearCache('categories');
    }
}