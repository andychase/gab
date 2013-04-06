<?php

function parser_embed($gab, $text) {
    require_once 'auto_video_embed_view.php';
    return parser_video_embed($text);
}

function auto_link($gab, $text) {
    require_once 'auto_link.php';
    return auto_link_text($text);
}

$gab->bindTrigger(gab_triggers::PARSE, "auto_link");
$gab->bindTrigger(gab_triggers::PARSE, "parser_embed");

