<?php
/*
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE
*/

require_once("gab_config.php");

class gab extends gab_settings
{
    /// // ////// /////// ////////////////////
    //     GAB - Tiny Forums by Andy Chase.

    // Page Controllers
    // Controllers are loaded left to right
    public $controllers = array(
        // ~ Represents the path of the $controller_folder
        "posts" => array('~new_thread.php', '~posts.php'),
        "single_category" => array('~single_category.php', '~posts.php'),
        "single_post" => array('~moderate.php', '~new_reply.php', '~single_post.php'),
        "new_thread" => array('~new_thread.php', '~post.php'),
        "categories" => array('~new_category.php', "~categories.php"),
        "users" => array("~users.php"),
        "single_user" => array("~single_user.php"),
        "messages" => array('~new_message.php', "~messages.php"),
    );

    public $templates = array(
        "posts" => "extends:base.tpl|posts.tpl",
        "single_category" => "extends:base.tpl|posts.tpl",
        "single_post" => "extends:base.tpl|single_post.tpl",
        "new_thread" => "extends:base.tpl|new_thread_page.tpl",
        "categories" => "extends:base.tpl|categories.tpl",
        "users" => "extends:base.tpl|users.tpl",
        "single_user" => "extends:base.tpl|single_user.tpl",
        "messages" => "extends:base.tpl|messages.tpl",
    );

    public $smarty;
    public $pdo;
    public $caching = 1;

    private $extension_pages = array();
    private $extension_pages_ext = array();
    private $current_extension;
    private $current_page;
    private $cache_id = '';
    private $javascript = array();
    private $css = array();
    private $parsers = array();

    public $user_id;
    public $user_email_hash;
    public $user_name;

    // Extension API /////////////////////////

    function addController($controller_name, $page, $order="") {
        $path =
            $this->extensions_folder .
                DIRECTORY_SEPARATOR .
                $this->current_extension .
                DIRECTORY_SEPARATOR . $controller_name;
        if ($order == "pre")
            array_unshift($this->controllers[$page], $path);
        else
            $this->controllers[$page][] = $path;
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

    function addJavascript($name, $order="") {
        $path =
            $this->extensions_folder .
            DIRECTORY_SEPARATOR .
            $this->current_extension .
            DIRECTORY_SEPARATOR . $name;
        if ($order == "pre")
             array_unshift($this->javascript, $path);
        else
            $this->javascript[] = $path;
    }

    function addCss($name) {
        $this->css[] =
            $this->extensions_folder .
                DIRECTORY_SEPARATOR .
                $this->current_extension .
                DIRECTORY_SEPARATOR . $name;
    }

    function addParser($function_name, $order="") {
        if ($order == "pre") array_unshift($this->parsers, $function_name);
        else $this->parsers[] = $function_name;
    }

    function hasPermission($permission) {
        // Returns true if current user has permissions greater than or higher than $permission
        if(array_key_exists($permission, $this->trust_levels))
            return $_SESSION['user_trust'] >= $this->trust_levels[$permission];
        else
            return false;
    }

    // Template //////////////////////////////
    function assign($var_name, $var) {
        $this->smarty->assign($var_name, $var);
    }

    function clearCache($page, $cache_id=null) {
        $this->smarty->clearCache($this->templates[$page], $cache_id);
    }

    function isCached() {
        return $this->smarty->isCached($this->templates[$this->current_page], $this->cache_id);
    }

    function displayGeneric($template) {
        $this->addTemplate("posts", $template);
        $this->smarty->caching = $this->caching;
        $this->smarty->display($this->templates['posts']);
    }

    function addCacheId($id) {
        // The most important Cache Id should be added last.
        $this->cache_id = "$id|".$this->cache_id;
    }

    public function parse($text) {
        foreach($this->parsers as $parser)
            $text = $parser($text);
        return $text;
    }

    public function avatar($email_hash, $size=40, $default_style='retro') {
        return "http://www.gravatar.com/avatar/{$email_hash}?s={$size}&d={$default_style}";
    }

    function gab(Smarty $smarty, $pdo)
    {
        $smarty->setTemplateDir($this->templates_folder);
        $this->smarty = $smarty;
        $this->pdo = $pdo;

        $this->addSmartyPlugin("modifier", "avatar", array($this, 'avatar'));
        $this->addSmartyPlugin("modifier", "parse", array($this, 'parse'));

        // Prepare Extensions ////////////////////////////

        if (is_dir($this->extensions_folder))
            foreach (new DirectoryIterator($this->extensions_folder) as $item) {
                $name = $this->extensions_folder."/".$item->getFilename()."/".$item->getFilename().'.php';
                if (!$item->isDot() && $item->isDir() && is_file($name)) {
                    $this->current_extension = $item->getFilename();
                    require($name);
                }
        }
    }

    function run($page, $matches, $user_id, $user_email_hash, $user_name, $user_trust) {
        $this->assign('base_url', $this->base_url);
        $this->assign('ext_url', $this->base_url . '/' . $this->extensions_folder);
        $this->current_page = $page;

        require_once("min/utils.php");
        $this->assign('js_url', Minify_getUri($this->javascript));
        $this->assign('css_url', Minify_getUri($this->css));

        // User
        $this->assign("trust_levels", $this->trust_levels);
        if ($user_id) {
            $this->assign('logged_in', true);
            $this->assign('user_logged_in', $user_id);
            $this->assign('user_trust', $user_trust);
            $this->addCacheId($user_id);
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
            foreach($this->controllers[$page] as $controller) {
                if ($controller[0] == "~")
                    require($this->controller_folder.DIRECTORY_SEPARATOR.substr($controller, 1));
                else
                    require($controller);
            }
            $this->smarty->caching = $this->caching;
            $this->smarty->display($this->templates[$page], $this->cache_id);
        }
    }

    // ////// /////// ////////////////////////
}