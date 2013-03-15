<?php

function get_themes($gab) {
    $themes = array();
    // Populate themes from ext folder
    foreach (new DirectoryIterator($gab->extensions_folder) as $file)
        if (substr($file, 0, 6) == "theme_")
            $themes[] = array(
                "name" => (string) $file,
                "thumb" => "{$gab->extensions_folder}/{$file}/screenshot.png"
            );
    // Check to see if they are active
    foreach($themes as &$theme)
        if (in_array($theme['name'], $gab->ext))
            $theme['active'] = true;
        else
            $theme['active'] = false;
    return $themes;
}

function get_exts($gab) {
    $exts = array();
    // Populate ext from ext folder
    foreach (new DirectoryIterator($gab->extensions_folder) as $file) {
        if (!$file->isDot() && $file->isDir() && substr($file, 0, 6) != "theme_") {
            $readme = $gab->extensions_folder . DIRECTORY_SEPARATOR .$file.DIRECTORY_SEPARATOR.'readme.txt';
            if (is_file($readme))
                $exts[] = array(
                    "name" => (string) $file,
                    "desc" => substr(file_get_contents($readme), 0, 40)
                );
            else
                $exts[] = array(
                    "name" => (string) $file,
                );
        }
    }
    // Check to see if they are active
    foreach($exts as &$ext)
        if (in_array($ext['name'], $gab->ext))
            $ext['active'] = true;
        else
            $ext['active'] = false;

    return $exts;
}

function feat_options_page($gab) {
    if($gab->user_trust < 99) return;

    $gab->assign("section", $_GET['section']);
    $gab->assign("name_disabled", 'disabled="disabled"');
    $gab->assign("trust_permissions",$gab->trust_levels);
    if ($_GET['section'] == "theme") {
        $gab->assign("exts", $gab->ext);
        $gab->assign("themes", get_themes($gab));
    }
    if ($_GET['section'] == "ext")
        $gab->assign("exts", get_exts($gab));

    $gab->displayGeneric('options_page.tpl');
}


$this->addTemplate('*', 'options_link.tpl');
$this->addPage('options', 'feat_options_page');