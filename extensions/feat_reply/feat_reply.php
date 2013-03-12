<?php

function reply_link($text) {
    // Only activate if first character is an (at)
    $text = preg_replace('/\@([a-z]+):([0-9]+)/i', "<a href='#post$2' class='reply_to'> Reply to $1 </a>", $text);
    return $text;
}


$this->addParser("reply_link");
$this->addJavascript('reply.js');
$this->addCss('reply.css');