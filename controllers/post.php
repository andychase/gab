<?php

$this->caching = 2;
$this->cache_lifetime = 360;

$post_id = $matches[1];
$skip = intval($_GET['skip']);
$GLOBALS['cache_id'] = "$post_id|$skip|${GLOBALS['cache_id']}";

forum::add_view($post_id);
//if (!$this->isCached('forum/post.tpl', $GLOBALS['cache_id'])) {
    $this->assign("forum_section", "posts");
    $this->assign("topic", forum::get_post($post_id));
    $this->assign("replies", forum::get_replies($post_id, $skip));
//}