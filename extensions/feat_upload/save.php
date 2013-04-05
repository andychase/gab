<?php

function formatBytes($size) {
    $filesizename = array(" Bytes", " KB", " MB", " GB");
    return $size ? round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $filesizename[$i] : '0 Bytes';
}

function save_file_uploads($gab) {
    $output = array();
    foreach ($_FILES as $file) {
        if(
            $file['error'] == 0 &&
            $file["size"] < 2000000 &&
            $file["size"] > 0
        ) {
            $filename = basename($file['name']);
            $ext = substr($filename, strrpos($filename, '.') + 1);
            $new_name = uniqid('', true) . ".$ext";
            $new_filename = $gab->uploads_folder.DIRECTORY_SEPARATOR . $new_name;
            $filesize = formatBytes(filesize($file['tmp_name']));
            $is_image = (substr($file['type'], 0, 6) == 'image/');
            move_uploaded_file($file['tmp_name'], $new_filename);
            $output[] = array($is_image, $new_name, $new_filename, $filename, $filesize);
        }
    }
    return $output;
}