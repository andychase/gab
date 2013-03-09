<?php

$this->smarty->caching = 2;
$this->smarty->cache_lifetime = 360;

$post_id = $matches[1];
$skip = intval($_GET['skip']);
$edit = intval($_GET['edit']);
$this->addCacheId('e:'.$edit);
$this->addCacheId('u:'.$_SESSION['user_logged_in']);
$this->addCacheId("t:".$_SESSION['user_trust']);
$this->addCacheId("$post_id|$skip");

if($edit) {
    $this->caching = 0;
    $this->assign('edit', $edit);
} else {
    $this->assign('edit', false);
}

if (!$this->isCached()) {
    post::add_view($post_id);
    if($this->hasPermission('see_deleted')) {
        $topic = post::get_post($post_id, true);
        $replies = array_merge(array($topic), post::get_replies($post_id, $skip, true));
    } else {
        $topic = post::get_post($post_id);
        $replies = array_merge(array($topic), post::get_replies($post_id, $skip));
    }

    $this->assign("forum_section", "posts");
    $this->assign("topic", $topic);
    $this->assign("replies", $replies);
    $this->assign("number_of_items", $topic['replies']);
}