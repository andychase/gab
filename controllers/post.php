<?php

$this->smarty->caching = 2;
$this->smarty->cache_lifetime = 360;

$post_id = $matches[1];
$skip = intval($_GET['skip']);
$this->addCacheId("$post_id|$skip");

if (!$this->isCached()) {
    forum::add_view($post_id);
    $topic = forum::get_post($post_id);
    $replies = array_merge(array($topic), forum::get_replies($post_id, $skip));

    $this->assign("forum_section", "posts");
    $this->assign("topic", $topic);
    $this->assign("replies", $replies);
}