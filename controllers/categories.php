<?php

if (!$this->isCached()) {
    $this->assign("forum_section", "cat");
    $this->assign("categories", category::get_categories());
}
