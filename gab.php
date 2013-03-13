<?php
/*
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE
*/

require_once('gab_config.php');

class gab extends gab_settings
{
    /// // ////// /////// ////////////////////
    //     GAB - Tiny Forums by Andy Chase.

    // Page Controllers
    // Controllers are loaded left to right
    public $controllers = array(
        // ~ Represents the path of the $controller_folder
        'posts' => array('~new_thread.php', '~posts.php'),
        'single_category' => array('~single_category.php', '~posts.php'),
        'single_post' => array('~moderate.php', '~new_reply.php', '~single_post.php'),
        'new_thread' => array('~new_thread.php', '~post.php'),
        'categories' => array('~new_category.php', '~categories.php'),
        'users' => array('~users.php'),
        'single_user' => array('~single_user.php'),
        'messages' => array('~new_message.php', '~messages.php'),
    );

    public $templates = array(
        'posts' => 'extends:base.tpl|posts.tpl',
        'single_category' => 'extends:base.tpl|posts.tpl',
        'single_post' => 'extends:base.tpl|single_post.tpl',
        'new_thread' => 'extends:base.tpl|new_thread_page.tpl',
        'categories' => 'extends:base.tpl|categories.tpl',
        'users' => 'extends:base.tpl|users.tpl',
        'single_user' => 'extends:base.tpl|single_user.tpl',
        'messages' => 'extends:base.tpl|messages.tpl',
    );

    public $smarty;
    public $pdo;
    // By default, we cache
    public $caching = 1;

    // List of pages provided by extensions
    private $extension_pages = array();
    // Current extension for each of these pages
    private $extension_pages_ext = array();
    // When loading up extensions, the extension that is loading is called here
    private $current_extension;
    // When a page is being processed, it is placed here
    private $current_page;
    // The id that allows us to have different caches for the same file
    private $cache_id = '';
    // Extensions can add to these lists to include stuff
    private $javascript = array();
    private $css = array();
    // Every function in here is run for places like posts' message bodies
    private $parsers = array();
    // Every function in here is run when a post gets added/deleted/updated
    private $post_changed_callbacks = array();

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
            foreach(array_keys($this->templates) as $page) {
                $tpl = $this->templates[$page];
                if (!$order)
                    $this->templates[$page] .= "|file:$folder/$ext/$template_name";
                else if ($order == 'pre' && strpos($tpl, '|') !== False)
                    $this->templates[$page] = substr_replace($tpl, "|file:$folder/$ext/$template_name", strpos($tpl, '|'), 0);
            }
        }
        else {
            $tpl = $this->templates[$page];
            if (!$order)
                $this->templates[$page] .= "|file:$folder/$ext/$template_name";
            else if ($order == 'pre' && strpos($tpl, '|') !== False)
                $this->templates[$page] = substr_replace($tpl, "|file:$folder/$ext/$template_name", strpos($tpl, '|'), 0);
        }
    }

    function addJavascript($name, $order='') {
        $path =
            '//'.
            $this->extensions_folder .
            DIRECTORY_SEPARATOR .
            $this->current_extension .
            DIRECTORY_SEPARATOR . $name;
        if ($order == 'pre')
             array_unshift($this->javascript, $path);
        else
            $this->javascript[] = $path;
    }

    function addCss($name) {
        $this->css[] =
            '//'.
            $this->extensions_folder .
                DIRECTORY_SEPARATOR .
                $this->current_extension .
                DIRECTORY_SEPARATOR . $name;
    }

    function addParser($function_name, $order="") {
        // Callbacks called when message bodies are rendered
        // Callbacks should have signature: function ($text) {return $text;}
        if ($order == 'pre') array_unshift($this->parsers, $function_name);
        else $this->parsers[] = $function_name;
    }

    function hasPermission($permission) {
        // Returns true if current user has permissions greater than or higher than $permission
        if(array_key_exists($permission, $this->trust_levels))
            return $_SESSION['user_trust'] >= $this->trust_levels[$permission];
        else
            return false;
    }

    function addPostChangedCallback($function_name, $order="") {
        // Called on post creations/update/delete
        // Callbacks should have signature: function ($gab, $post_id) {}
        if ($order == 'pre') array_unshift($this->post_changed_callbacks, $function_name);
        else $this->post_changed_callbacks[] = $function_name;
    }

    // Template //////////////////////////////
    function assign($var_name, $var) {
        $this->smarty->assign($var_name, $var);
    }

    function clearCache($page, $cache_id=null) {
        global $forum_id;
        $this->smarty->clearCache($this->templates[$page], "$forum_id|$cache_id");
    }

    function isCached() {
        global $forum_id;
        return $this->smarty->isCached($this->templates[$this->current_page], "$forum_id|".$this->cache_id);
    }

    function displayGeneric($template) {
        $this->addTemplate('posts', $template);
        $this->smarty->caching = $this->caching;
        $this->smarty->display($this->templates['posts']);
    }

    function addCacheId($id) {
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

        $this->addSmartyPlugin('modifier', 'avatar', array($this, 'avatar'));
        $this->addSmartyPlugin('modifier', 'parse', array($this, 'parse'));

        // Prepare Extensions ////////////////////////////
        foreach($this->ext as $name) {
            $this->current_extension = $name;
            require($this->extensions_folder.
                    DIRECTORY_SEPARATOR.
                    $name.
                    DIRECTORY_SEPARATOR.
                    "$name.php");
        }
    }

    function prepare_static() {
        // Prepare javascript and css list & hash. Why?:
        //   Basic way of hiding what extensions you are using
        //   The list can get kinda long
        if (!$this->isCached()) {
            $js_hash = hash('md4', implode('/',$this->javascript));
            $css_hash = hash('md4', implode('/',$this->css));
            if(!is_file('min/groups/'.$js_hash.'.php'))
                file_put_contents('min/groups/'.$js_hash, serialize(array($js_hash => $this->javascript)));
            if(!is_file('min/groups/'.$css_hash.'.php'))
                file_put_contents('min/groups/'.$css_hash, serialize(array($css_hash => $this->css)));
            $this->assign('js_url', '/min/?g='.$js_hash);
            $this->assign('css_url', '/min/?g='.$css_hash);
        }
    }

    function run($page, $matches, $user_id, $user_email_hash, $user_name, $user_trust, $forum_id=2) {
        $this->assign('base_url', $this->base_url);
        $this->assign('ext_url', $this->base_url . '/' . $this->extensions_folder);
        $this->current_page = $page;

        $GLOBALS['forum_id'] = $forum_id;


        // User
        $this->assign("trust_levels", $this->trust_levels);
        if ($user_id) {
            $this->assign('logged_in', true);
            $this->assign('user_logged_in', $user_id);
            $this->assign('user_trust', $user_trust);
            $this->addCacheId($user_id);
        }

        require_once($this->model_folder.DIRECTORY_SEPARATOR."model.php");
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
            $this->prepare_static();
            $this->smarty->display($this->templates[$page], "$forum_id|".$this->cache_id);
        }
    }

    // ////// /////// ////////////////////////
}