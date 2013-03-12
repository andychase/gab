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

    // @replies
    $reply_regex = '/^\@[a-z]+:([0-9]+)/i';

    foreach($replies as &$reply) {
        if ($reply['message'][0] == "@") {
            $matches = array();
            preg_match($reply_regex, $reply['message'], $matches);
            if(count($matches) > 0)
                $reply['reply'] = post::get_reply($matches[1]);
            $reply['message'] = substr($reply['message'], strpos($reply['message'], " "));
        }
    }

    $this->assign("forum_section", "posts");
    $this->assign("topic", $topic);
    $this->assign("replies", $replies);
    $this->assign("number_of_items", $topic['replies']);
}