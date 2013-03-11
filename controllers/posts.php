<?php

$skip = intval($_GET['skip']);
$sort_by = $_GET['sort'];
$sort_down = true;
if($_GET['dir']) $sort_down = false;
$this->addCacheId('st:'.$sort_by);
$this->addCacheId('s:'.$skip);
if($sort_down) $this->addCacheId('sort_down');

$this->addCacheId("category:$category");
if (!$this->isCached()) {
    $sort_by = $_GET['sort'];
    $this->assign("sort_by", $sort_by);
    $this->assign("sort_down", $sort_down);
    $this->assign("categories", category::get_category_list());
    if($category == null) {
        $cat_id = null;
        $this->assign("forum_section", "posts");
    } else {
        $cat_id = category::get_category_id($category);
        $this->assign("forum_section", "cat");
        $this->assign("category", $category);
    }
    $this->assign("current_skip", $skip);
    $this->assign("posts", post::get_posts($cat_id, $sort_by, $sort_down, $skip));
}
