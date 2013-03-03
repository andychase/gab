<?php

function parser_embed($message) {
    require_once(dirname(__dir__)."/parser_embed/auto_video_embed_view.php");
    return parser_video_embed($message);
}

function auto_link($text) {
    require_once(dirname(__dir__)."/parser_embed/auto_link.php");
    return auto_link_text($text);
}

$this->addParser("auto_link");
$this->addParser("parser_embed");

