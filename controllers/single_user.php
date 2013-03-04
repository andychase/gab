<?php

$user_name = $matches[1];
$this->addCacheId($user_name);
if (!$this->isCached()) {
    $user = forum::get_user_info(trim($user_name));
    $this->assign("user", $user);
    $this->assign("user_name", $user_name);
    $this->assign("forum_section", "users");

    $this->assign("user_posts", forum::get_user_posts($user['id']));
}