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
    foreach($exts as $i => $ext)
        if (in_array($ext['name'], $gab->ext))
            $exts[$i]['active'] = true;
        else
            $exts[$i]['active'] = false;

    // Don't display exts that we want blacklisted
    if ($gab->ext_blacklist)
        foreach($exts as $i => $ext)
            if (in_array($ext['name'], $gab->ext_blacklist))
                unset($exts[$i]);
    sort($exts);
    return $exts;
}

function feat_options_page($gab) {
    if (!$gab->user->hasPermission(permission::OPTIONS)) return;
    if ($_POST['do']) return save_changes($gab);

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


function save_changes($gab) {
    global $forum_id;
    require(dirname(__FIlE__).'/output_custom_config.php');
    // Name & Desc
    if ($_POST['name'])
        $name = $_POST['name'];
    else
        $name = $gab->forum_name;
    if ($_POST['description'])
        $desc = $_POST['description'];
    else
        $desc = $gab->forum_description;
    // Theme
    $new_ext = $gab->ext;
    if ($_GET['section'] == 'theme') {
        $new_ext = $gab->ext;
        foreach ($gab->ext as $i => $ext)
            if (substr($ext, 0, 6) == 'theme_')
                unset($new_ext[$i]);
        if ($_POST['theme'] != 'none')
            $new_ext[] = $_POST['theme'];
    }
    // Ext
    if ($_GET['section'] == 'ext') {
        $new_ext = array();
        foreach ($gab->ext as $ext)
            if (substr($ext, 0, 6) == 'theme_')
                $new_ext = array($ext);
        $exts = get_exts($gab);
        foreach ($exts as &$ext) {
            if ($_POST[$ext['name']] == 'on')
                $new_ext[] = $ext['name'];
            if (substr($ext['name'], 0, 6) == 'theme_')
                $new_ext[] = $ext['name'];
        }

        // Add in blacklisted exts
        if ($gab->ext_blacklist)
            $new_ext = array_merge($new_ext, $gab->ext_blacklist);
    }
    output_custom_config(
        $forum_id,
        $name,
        $desc,
        $new_ext,
        $gab->ext_options_extends,
        $gab->ext_options_options_class);
    $gab->clearCache(null, null);
    header("Location: /ext/options/?section=".$_GET['section']);
}

$this->addTemplate('*', 'options_link.tpl');
$this->addPage('options', 'feat_options_page');