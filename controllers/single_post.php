<?php

$this->smarty->caching = 2;
$this->smarty->cache_lifetime = 360;

$post_id = $matches[1];
$skip = intval($_GET['skip']);
$edit = intval($_GET['edit']);
$this->addCacheId('e:'.$edit);
$this->addCacheId('u:'.$this->user->id);
$this->addCacheId("$post_id|$skip");

if($edit) {
    $this->caching = 0;
    $this->assign('edit', $edit);
} else {
    $this->assign('edit', false);
}

if (!$this->isCached()) {
    post::add_view($post_id);

    // Merge topic & replies and add permissions
    $can_see_deleted = $this->user->hasPermission(permission::SEE_DELETED);
    $topic = post::get_post($post_id);
    $replies = array_merge(array($topic), post::get_replies($post_id, $skip, $can_see_deleted));
    foreach($replies as &$reply) {
        $reply['actions'] = array();
        if ($this->user->hasPermission(permission::DELETE,  $topic['reply_to'], $reply['author'], $reply['visibility']))
            $reply['actions'][] = 'delete';
        if ($this->user->hasPermission(permission::RECOVER, $topic['reply_to'], $reply['author'], $reply['visibility']))
            $reply['actions'][] = 'recover';
        if ($this->user->hasPermission(permission::EDIT,    $topic['reply_to'], $reply['author'], $reply['visibility']))
            $reply['actions'][] = 'edit';
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