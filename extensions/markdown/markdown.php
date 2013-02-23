<?php

function smarty_modifier_markdown($text) {
    require_once(dirname(__dir__)."/markdown/markdown_lib.php");
    return Markdown($text);
}

$this->addSmartyPlugin("modifier", "markdown", "smarty_modifier_markdown");
$this->addTemplate('single_post', 'markdown.tpl');
