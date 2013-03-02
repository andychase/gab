<?php

if ($this->hasPermission('delete') && ($_GET['delete'] || $_GET['recover'])) {
    $post_id = $matches[1];
    if (!empty($_GET['recover']))
        forum::hide_post($_GET['recover'], true);
    else
        forum::hide_post($_GET['delete']);
    $this->clearCache('single_post', $post_id);
    $this->clearCache('all_posts');
    $this->clearCache('categories');
}