<?php

$this->caching = 0;
$this->assign("forum_section", "msg");
$this->assign("messages", forum::get_messages($_SESSION['user_name']));
