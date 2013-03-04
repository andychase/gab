<?php

if (!$this->isCached()) {
    $this->assign("forum_section", "users");
    $this->assign("users", forum::get_users());
}
