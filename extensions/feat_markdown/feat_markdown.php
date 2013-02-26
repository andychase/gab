<?php

function smarty_modifier_markdown($text) {
    require_once(dirname(__dir__)."/feat_markdown/markdown.php");
    return Markdown($text);
}

$this->addSmartyPlugin("modifier", "markdown", "smarty_modifier_markdown");
$this->addTemplate('single_post', 'markdown.tpl');
$this->addJavascript('markdown.js');
