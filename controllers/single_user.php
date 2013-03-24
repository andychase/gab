<?php

$user_name = urldecode($matches[1]);
$this->addCacheId($user_name);

if (!$this->isCached()) {
    $user = user::get_user_info(trim($user_name));
    $this->assign("user", $user);
    $this->assign("user_name", $user_name);
    $this->assign("forum_section", "users");

    $this->assign("user_posts", user::get_user_posts($user['id']));
}