<?php
if (($_GET['delete'] || $_GET['recover'] || $_POST['edit']) && count($matches) > 0) {

    $post_id = intval($_GET['delete'] . $_GET['recover'] . $_POST['edit']);
    $post = post::get_simple($post_id);

    if ($_GET['recover'] && $this->user->hasPermission(permission::RECOVER))
        post::hide_post($post_id, true);
    else if ($_GET['delete'] && $this->user->hasPermission(permission::DELETE, $post['author'], $post['visibility']))
        post::hide_post($post_id);
    else if ($_POST['edit'] && $this->user->hasPermission(permission::EDIT, $post['author'], $post['visibility']))
        post::modify_post($post_id, $_POST['text']);

    $this->trigger('moderate', $post_id);

    $this->clearCache('single_post', $matches[1]);
    $this->clearCache('posts');
    $this->clearCache('categories');
    $this->clearCache('messages');

    header("location: ./");
    $this->redirect = true;
}