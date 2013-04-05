<?php

$this->addCacheId($this->user->id);

if (!$this->isCached()) {
    $this->assign("forum_section", "users");
    if ($this->user->id)
        $this->assign("you", user::get_user($this->user->id));
    $this->assign("users", user::get_users());
}
