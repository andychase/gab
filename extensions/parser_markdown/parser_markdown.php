<?php

function smarty_modifier_markdown($text) {
    require_once(dirname(__dir__)."/parser_markdown/markdown.php");
    return Markdown($text);
}

function purify_html($text) {
    require_once(dirname(__dir__)."/parser_markdown/HTMLPurifier.standalone.php");
    $purifier = new HTMLPurifier;
    return $purifier->purify($text);
}

$this->addParser("purify_html", "pre");
$this->addParser("smarty_modifier_markdown", "pre");
$this->addJavascript('markdown.js');
