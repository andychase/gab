<?php

$this->addCacheId("trust:".$_SESSION['user_trust']);
if (!$this->isCached()) {
    $this->assign("forum_section", "cat");
    $this->assign("categories", category::get_categories());
}
