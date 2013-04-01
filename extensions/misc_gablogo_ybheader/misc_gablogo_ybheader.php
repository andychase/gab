<?php

$this->assign("ybheader_color", $this->getOption('color'));
$this->addCss('ybheader.css');
$this->addTemplate('*', 'ybheader.tpl');