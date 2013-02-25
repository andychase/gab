<?php
/*
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE
*/

class gab
{
    /// // ////// /////// ////////////////////
    //     GAB - Tiny Forums by Andy Chase.

    // Setup /////////////////////////////////

    // Paths
    // Do not include the trailing slash on path names
    public $model_location = "gab_model.php";
    public $templates_folder = "templates";
    public $templates_folder_section = "templates/sections";
    public $controller_folder = "controllers";
    public $extensions_folder = "extensions";

    // Urls
    public $base_url = "";
    public $assets_url = "assets";

    // Page Controllers
    // Controllers are loaded left to right
    public $controllers = array(
        "all_posts" => array('new_thread', 'posts'),
        "single_category" => array('single_category'),
        "single_post" => array('new_reply', 'post'),
        "new_thread" => array('new_thread', 'post'),
        "categories" => array('new_category', "categories"),
        "messages" => array('new_message', "messages"),
    );

    public $templates = array(
        "all_posts" => "extends:base.tpl|all_posts.tpl",
        "single_category" => "extends:base.tpl|all_posts.tpl",
        "single_post" => "extends:base.tpl|single_post.tpl",
        "new_thread" => "extends:base.tpl|new_thread_page.tpl",
        "categories" => "extends:base.tpl|categories.tpl",
        "messages" => "extends:base.tpl|messages.tpl",
    );

    public $smarty;
    public $pdo;
    public $caching;

    private $extension_pages = array();
    private $extension_pages_ext = array();
    private $current_extension;
    private $javascript = array();
    private $css = array();

    public $user_id;
    public $user_email_hash;
    public $user_name;

    // Extension API /////////////////////////

    function addController($controller_name, $page, $order="") {

    }

    function addPage($page, $callback_function) {
        $this->extension_pages[$page] = $callback_function;
        $this->extension_pages_ext[$page] = $this->current_extension;
    }

    function addSmartyPlugin($plugin_type, $plugin_name, $function_name) {
        $this->smarty->registerPlugin($plugin_type, $plugin_name, $function_name);
    }

    function addTemplate($page, $template_name, $order="") {
        $folder = $this->extensions_folder;
        $ext = $this->current_extension;

        if ($page=='*') {
            foreach(array_keys($this->templates) as $tpl)
                $this->addTemplate($tpl, $template_name, $order);
            return;
        }
        if (!array_key_exists($page, $this->templates))
            throw new Exception("Extension $ext error adding controller: Not a page with that name.");
        $tpl = $this->templates[$page];
        if (!$order)
            $this->templates[$page] .= "|file:$folder/$ext/$template_name";
        else if ($order == "pre" && strpos($tpl, "|") !== False)
            $this->templates[$page] = substr_replace($tpl, "|file:$folder/$ext/$template_name", strpos($tpl, "|"), 0);

    }

    function addJavascript($name) {
        $this->javascript[] =
            $this->extensions_folder .
            DIRECTORY_SEPARATOR .
            $this->current_extension .
            DIRECTORY_SEPARATOR . $name;
    }

    function addCss($name) {
        $this->css[] =
            $this->extensions_folder .
                DIRECTORY_SEPARATOR .
                $this->current_extension .
                DIRECTORY_SEPARATOR . $name;
    }

    function addField($field_name, $field_type, $model_actions) {

    }


    // Template //////////////////////////////
    function assign($var_name, $var) {
        $this->smarty->assign($var_name, $var);
    }

    function clearCache($template, $cache_id) {
        $this->smarty->clearCache($template, $cache_id);
    }

    function isCached($template, $cache_id) {
        return $this->smarty->clearCache($template, $cache_id);
    }

    function displayGeneric($template) {
        $this->addTemplate("all_posts", $template);
        $this->smarty->display($this->templates['all_posts']);
    }


    function gab(Smarty $smarty, $pdo)
    {
        $smarty->setTemplateDir($this->templates_folder);
        $this->smarty = $smarty;
        $this->pdo = $pdo;

        $assets_url = $this->assets_url;
        $this->css = array("{$assets_url}/gab.css");
        $this->javascript = array("{$assets_url}/jquery.js", "{$assets_url}/jquery.cookie.js",
            "{$assets_url}/markdown.js", "{$assets_url}/hash.js", "{$assets_url}/script.js");

    // Extensions ////////////////////////////

        if (is_dir($this->extensions_folder))
            foreach (new DirectoryIterator($this->extensions_folder) as $item) {
                $name = $this->extensions_folder."/".$item->getFilename()."/".$item->getFilename().'.php';
                if (!$item->isDot() && $item->isDir() && is_file($name)) {
                    $this->current_extension = $item->getFilename();
                    require($name);
                }
        }

    }

    function run($page, $matches, $user_id, $user_email_hash, $user_name) {
        $this->assign('base_url', $this->base_url);
        $this->assign('ext_url', $this->base_url . '/' . $this->extensions_folder);

        require_once("min/utils.php");
        $this->assign('js_url', Minify_getUri($this->javascript));
        $this->assign('css_url', Minify_getUri($this->css));
        $this->assign('assets_url', $this->assets_url);

        if ($user_id) {
            $this->assign('logged_in', true);
            $this->assign('user_logged_in', $user_id);
        }

        require_once($this->model_location);
        if ($page == "ext") {
            if (array_key_exists($matches[1], $this->extension_pages)) {
                $this->current_extension = $this->extension_pages_ext[$matches[1]];
                call_user_func_array($this->extension_pages[$matches[1]], array($this));
            }
            else
                echo "Not found";
        } else {
            foreach($this->controllers[$page] as $controller)
                require($this->controller_folder.DIRECTORY_SEPARATOR.$controller.'.php');
            $this->smarty->display($this->templates[$page]);
        }
    }

    // ////// /////// ////////////////////////
}