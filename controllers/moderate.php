<?php
if (($_GET['delete'] || $_GET['recover'] || $_POST['edit']) && count($matches) > 0) {

    $post_id = intval($_GET['delete'] . $_GET['recover'] . $_POST['edit']);
    $post = post::get_simple($post_id);

    if ($_GET['recover'] && $this->hasPermission(actions::RECOVER))
        post::hide_post($post_id, true);
    else if ($_GET['delete'] && $this->hasPermission(actions::DELETE, $post['author'], $post['visibility']))
        post::hide_post($post_id);
    else if ($_POST['edit'] && $this->hasPermission(actions::EDIT, $post['author'], $post['visibility']))
        post::modify_post($post_id, $_POST['text']);

    $this->changed_post_id = $post_id;

    $this->clearCache('single_post', $matches[1]);
    $this->clearCache('posts');
    $this->clearCache('categories');
    $this->clearCache('messages');

    header("location: ./");
    $this->redirect = true;
}