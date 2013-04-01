<?php

$this->addOption("custom_css", "", null, null, null, "textarea");
if($this->getOption("custom_css")) {
$this->addTemplate('*', 'custom_css.tpl');
$this->assign("silicone_custom_css", $this->getOption("custom_css"));
}
