<?php

if (!$this->isCached()) {
    $this->assign("categories", forum::get_category_list());
    $this->assign("forum_section", "posts");
    $this->assign("posts", forum::get_posts());
}
