<?php

$gab->addOption('allow_uploads', false, null, null, null, 'boolean');
function ext_feat_upload($gab) {include 'upload.php'; }
$gab->bindTrigger('single_post', 'ext_feat_upload');
$gab->assign("allow_uploads", $gab->getOption('allow_uploads'));
$gab->addTemplate('single_post', 'upload_form.tpl');
$gab->addJavascript("upload_form.js");

