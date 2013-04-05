<?php
if ($gab->getOption('allow_uploads')) {
    require('save.php');
    foreach(save_file_uploads($gab  ) as $file) {
        $is_image = $file[0];
        $new_name = $file[1];
        $new_filename = $file[2];
        $filename = $file[3];
        $filesize = $file[4];
        if ($is_image) {
            require_once 'resize.php';
            $image_file_path = $gab->uploads_folder .
                DIRECTORY_SEPARATOR .
                'safe'.
                DIRECTORY_SEPARATOR .
                $new_name;
            resize($new_filename, $image_file_path, 300, 600);
            $_POST['text'] .=
                "<br />http://{$_SERVER['HTTP_HOST']}{$gab->base_url}/{$gab->uploads_folder}/safe/{$new_name} ";
        } else {
            $_POST['text'] .= "

                http://{$_SERVER['HTTP_HOST']}{$gab->base_url}/{$gab->uploads_folder}/{$filename}?id={$new_name} ({$filesize})";
        }
    }
}