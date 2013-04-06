<?php

function smarty_modifier_markdown($gab, $text) {
    require_once 'markdown.php';
    return Markdown($text);
}

$gab->bindTrigger(gab_triggers::PARSE, "smarty_modifier_markdown");
$gab->addJavascript('markdown.js');
