<?php

function display_search_page($gab) {
    $gab->displayGeneric('search_page.tpl');
}

$this->addController('new_thread', 'search_refresh.php');
$this->addController('single_post', 'search_refresh.php');
$this->addTemplate('*', 'search_link.tpl');
$this->addJavascript('search_.js');
$this->addPage('search', 'display_search_page');