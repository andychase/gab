<?php
/* Copyright (c) 2013 Andy Chase & Others.
MIT License
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE
*/

class gab
{
    /// // ////// /////// ////////////////////
    //     GAB - Tiny Forums by Andy Chase.

    // Setup /////////////////////////////

    // Paths
    // Do not include the trailing slash on path names
    public $model_location = "gab_model.php";
    public $templates_folder = "templates";
    public $templates_folder_section = "templates/sections";
    public $controller_folder = "controllers";
    public $extensions_folder = "extensions";

    // Urls
    public $base_url = "";
    public $assets_url = "/assets";

    // Page Controllers
    // Controllers are loaded left to right
    public $controllers = array(
        "all_posts" => array('new_thread', 'posts'),
        "single_post" => array('new_reply', 'post'),
        "new_thread" => array('new_thread', 'post'),
        "categories" => array('new_category', "categories"),
        "messages" => array('new_message', "messages"),
    );

    public $templates = array(
        "all_posts" => "extends:base.tpl|all_posts.tpl",
        "single_post" => "extends:base.tpl|single_post.tpl",
        "new_thread" => "extends:base.tpl|new_thread_page.tpl",
        "categories" => "extends:base.tpl|categories.tpl",
        "messages" => "extends:base.tpl|messages.tpl",
    );

    public $smarty;
    public $pdo;
    public $caching;

    //

    // Switch these out for different template layers
    function assign($var_name, $var) {
        $this->smarty->assign($var_name, $var);
    }

    function clearCache($template, $cache_id) {
        $this->smarty->clearCache($template, $cache_id);
    }

    function isCached($template, $cache_id) {
        return $this->smarty->clearCache($template, $cache_id);
    }

    function gab(Smarty $smarty, $pdo)
    {
        $smarty->setTemplateDir($this->templates_folder);
        $this->smarty = $smarty;
        $this->pdo = $pdo;

    // Extensions ////////////////////////
        if (is_dir($this->extensions_folder))
            foreach (new DirectoryIterator($this->extensions_folder) as $item) {
                $name = $this->extensions_folder."/".$item->getFilename()."/".$item->getFilename().'.php';
                if (!$item->isDot() && $item->isDir() && is_file($name))
                    require_once($name);
            }

    }

    function run($page, $matches, $user_id, $user_email_hash, $user_name) {
        $this->assign('base_url', $this->base_url);
        $this->assign('assets_url', $this->assets_url);

        require_once($this->model_location);
        foreach($this->controllers[$page] as $controller)
            require($this->controller_folder.DIRECTORY_SEPARATOR.$controller.'.php');
        $this->smarty->display($this->templates[$page]);
    }
    // ////// /////// ////////////////////
}