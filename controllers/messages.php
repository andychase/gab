<?php

if (!$this->isCached()) {
    $this->caching = 0;
    $this->assign("forum_section", "msg");
    $this->assign("messages", message::get_messages($_SESSION['user_name']));
}
