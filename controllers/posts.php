<?php
$this->assign("forum_section", "posts");
$this->assign("posts", forum::get_posts());
