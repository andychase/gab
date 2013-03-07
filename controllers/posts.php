<?php

$sort_by = $_GET['sort'];
$sort_down = true;
if($_GET['dir']) $sort_down = false;
$this->addCacheId('sort:'.$sort_by);
if($sort_down) $this->addCacheId('sort_down');

$this->addCacheId("category:$category");
if (!$this->isCached()) {
    $sort_by = $_GET['sort'];
    $this->assign("sort_by", $sort_by);
    $this->assign("sort_down", $sort_down);
    $this->assign("categories", category::get_category_list());
    if($category == null)  {
        $this->assign("forum_section", "posts");
    } else {
        $this->assign("forum_section", "cat");
        $this->assign("category", $category);
    }
    $this->assign("posts", post::get_posts($category, $sort_by, $sort_down));
}
