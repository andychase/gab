<?php

if (!$this->isCached()) {
    $this->assign("forum_section", "users");
    $this->assign("users", user::get_users());
}
