<?php

class gab_config {
    // General Forum //// /////////////////////////////////
    public $forum_id = 1;
    public $forum_name = "Gab";
    public $forum_description = "
    Embeddable, Extendable, Minimal next-gen forum software that's easy to deploy.
    ";

    // Deployment /////// /////////////////////////////////
    // Do not include the trailing slash on path names
    public $model_folder = "models";
    public $templates_folder = "templates";
    public $controller_folder = "controllers";
    public $extensions_folder = "extensions";
    public $uploads_folder = "uploads";

    // Examples: '' or '/gab'
    public $base_url = "";

    // Extension //////// ///////////////////////////
    // Active Extensions
    public $ext = array(
        "feat_options",
        "feat_openid",
        "misc_gablogo",
        "parser_embed",
        "theme_silicone",
        "parser_markdown",
        "ux_timeago",
        "search_",
    );

    // Ext options settings
    public $ext_options = array(
        'search_' => array (
            'url' => '',
            'auth' => array(/*Username:*/"", /*Password:*/"")
        ),
        'feat_options' => array(
            'blacklist' => array(),
            'extends' => 'gab',
            'options_class' => 'custom_gab',
            'filename' => 'custom_gab.php'
        )
    );
    public $ext_options_config = array();

    public $ext_options_blacklist = array();
    public $ext_options_extends = 'gab';
    public $ext_options_filename = 'custom_gab.php';
    public $ext_options_options_class = 'custom_gab';
}

// Permissions ////// ///////////////////////////////
class permission {
    CONST DELETE = 'mod';
    CONST RECOVER = 'mod';
    CONST EDIT = 'mod';
    CONST SEE_DELETED = 'mod';
    CONST MODIFY_OWN =  '*'; // <- Star means everyone.
    CONST OPTIONS = 'owner';
    CONST NEW_CATEGORY = 'mod';
    CONST ASSIGN_MODS = 'mod';
    CONST BAN = 'mod';
}