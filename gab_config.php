<?php

class gab_config {
    // General Forum //// /////////////////////////////////
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

    // Search_ extension settings
    public $search_url  = "";
    public $search_auth = array(/*Username:*/"", /*Password:*/"");
}

// Permissions ////// ///////////////////////////////
class permission {
    CONST DELETE = 'mod';
    CONST RECOVER = 'mod';
    CONST EDIT = 'mod';
    CONST SEE_DELETED = 'mod';
    CONST MODIFY_OWN =  '*'; // <- Star means everyone.
    CONST OPTIONS = 'owner';
    const NEW_CATEGORY = 'mod';
}