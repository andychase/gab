<?php

function smarty_modifier_markdown($text) {
    require_once(dirname(__dir__)."/markdown/markdown_lib.php");
    return Markdown($text);
}

$this->smarty->registerPlugin("modifier", "markdown", "smarty_modifier_markdown");
$this->templates['single_post'] .= '|file:'.dirname(__DIR__).'/markdown/markdown.tpl';
