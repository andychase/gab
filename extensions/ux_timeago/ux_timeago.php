<?php

function smarty_modifier_timeAgo( $date)
{
    // for using it with preceding 'vor'            index
    $timeStrings = array(   'recently',            // 0       <- now or future posts :-)
        's', 's',    // 1,1
        'min','mins',      // 3,3
        'hr', 'hrs',   // 5,5
        'day', 'days',         // 7,7
        'wk', 'wks',      // 9,9
        'mth', 'mths',      // 11,12
        'yr','yrs');      // 13,14
    $debug = false;
    $sec = time() - (( strtotime($date)) ? strtotime($date) : $date);

    if ( $sec <= 0) return $timeStrings[0];

    if ( $sec < 2) return $sec." ".$timeStrings[1];
    if ( $sec < 60) return $sec." ".$timeStrings[2];

    $min = $sec / 60;
    if ( floor($min+0.5) < 2) return floor($min+0.5)." ".$timeStrings[3];
    if ( $min < 60) return floor($min+0.5)." ".$timeStrings[4];

    $hrs = $min / 60;
    echo ($debug == true) ? "hours: ".floor($hrs+0.5)."<br />" : '';
    if ( floor($hrs+0.5) < 2) return floor($hrs+0.5)." ".$timeStrings[5];
    if ( $hrs < 24) return floor($hrs+0.5)." ".$timeStrings[6];

    $days = $hrs / 24;
    echo ($debug == true) ? "days: ".floor($days+0.5)."<br />" : '';
    if ( floor($days+0.5) < 2) return floor($days+0.5)." ".$timeStrings[7];
    if ( $days < 7) return floor($days+0.5)." ".$timeStrings[8];

    $weeks = $days / 7;
    echo ($debug == true) ? "weeks: ".floor($weeks+0.5)."<br />" : '';
    if ( floor($weeks+0.5) < 2) return floor($weeks+0.5)." ".$timeStrings[9];
    if ( $weeks < 4) return floor($weeks+0.5)." ".$timeStrings[10];

    $months = $weeks / 4;
    if ( floor($months+0.5) < 2) return floor($months+0.5)." ".$timeStrings[11];
    if ( $months < 12) return floor($months+0.5)." ".$timeStrings[12];

    $years = $weeks / 51;
    if ( floor($years+0.5) < 2) return floor($years+0.5)." ".$timeStrings[13];
    return floor($years+0.5)." ".$timeStrings[14];
}

$this->addSmartyPlugin("modifier", "timeAgo", "smarty_modifier_timeAgo");
$this->addTemplate('posts', 'timeago.tpl');
$this->addTemplate('categories', 'timeago.tpl');
$this->addTemplate('single_category', 'timeago.tpl');
$this->addTemplate('messages', 'timeago.tpl');
$this->addTemplate('single_post', 'timeago.tpl');
