<?php

define("FILE_PUT_CONTENTS_ATOMIC_TEMP", dirname(__FILE__)."/cache");
define("FILE_PUT_CONTENTS_ATOMIC_MODE", 0777);

function file_put_contents_atomic($filename, $content) {

    $temp = tempnam(FILE_PUT_CONTENTS_ATOMIC_TEMP, 'temp');
    if (!($f = @fopen($temp, 'wb'))) {
        $temp = FILE_PUT_CONTENTS_ATOMIC_TEMP . DIRECTORY_SEPARATOR . uniqid('temp');
        if (!($f = @fopen($temp, 'wb'))) {
            trigger_error("file_put_contents_atomic() : error writing temporary file '$temp'", E_USER_WARNING);
            return false;
        }
    }

    fwrite($f, $content);
    fclose($f);

    if (!@rename($temp, $filename)) {
        @unlink($filename);
        @rename($temp, $filename);
    }

    @chmod($filename, FILE_PUT_CONTENTS_ATOMIC_MODE);

    return true;

}

function assocarray_to_phparray($array) {
    $output = "array(";
    foreach($array as $key => $value) {
        if (is_string($value) || is_null($value))
            $value = "'" . addcslashes($value, "'") . "'";
        else if (is_array($value))
            $value = assocarray_to_phparray($value);

        $output .= "'$key' => $value,";
    }
    return $output . ')';
}

function array_to_phparray($array) {
    $output = "array(";
    foreach($array as $value)
        $output .= "'$value' ,";
    return $output . ')';
}

function output_custom_config($forum_id, $name, $description, $ext, $options, $extends, $class, $filename="custom_gab.php") {
    // Safety features
    $name = addcslashes($name, "'");
    $description = addcslashes($description, "'");
    foreach($ext as &$e)
        addslashes($e);
    $ext  = array_to_phparray($ext);
    $options = assocarray_to_phparray($options);
    file_put_contents_atomic($filename, <<<EOT
<?php
class $class extends $extends {
    public \$forum_id = $forum_id;
    public \$forum_name = '$name';
    public \$forum_description = '$description';
    public \$ext = $ext;
    public \$ext_options = $options;
}
EOT
    );
}