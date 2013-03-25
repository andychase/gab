<?php
/* Gab - Tiny Forums by Andy Chase. This software is released under the MIT licence. */
// Index.php - This file is intended for easy use of Gab, if you don't intent to embed it in your application.
//             It also shows how Gab is used.

ini_set('zlib.output_compression', 4096);
ini_set('display_errors','off');
if ($_SERVER["REMOTE_ADDR"] == "127.0.0.1")
    ini_set('display_errors','on');

// PDO
require("models/PDOLazyConnector.php");
$pdo = new PDOLazyConnector('mysql:host=localhost;dbname=gab', /*Username:*/'gab', /*Password:*/'');
$GLOBALS['pdo'] = $pdo;

// Smarty
require_once('smarty/Smarty.class.php');
$smarty = new Smarty;
$smarty->setCompileDir('smarty/compile');
$smarty->setCacheDir('smarty/cache');
$smarty->caching = 1;
$smarty->cache_lifetime = 900;
$compile_check = !$live;

// Gab
require_once('gab.php');
if (is_file('custom_gab.php')) {
    require('custom_gab.php');
    $gab = new custom_gab($smarty, $pdo);
} else {
    $gab = new gab($smarty, $pdo);
}

// Url Definitions
// Url Regex (Left Side) is routed to a file in controller_folder (Right side)
// Array variable $matches contains url patterns. $matches[1] contains first () group.
$urls = array(
    '/' => 'posts',
    '/new_thread' => 'posts',
    '/([0-9]+)' => 'single_post',
    '/categories' => 'categories',
    '/category/([a-zA-Z0-9_,\%.\-\'\+]+)' => 'single_category',
    '/messages' => 'messages',
    '/users' => 'users',
    '/user/([a-zA-Z0-9_,\%.\-\'\+]+)' => 'single_user',
    '/ext/([a-zA-Z0-9_]+)' => 'ext',
);

// Run! (Inspired by gluephp.com)
$page_found = false;
foreach ($urls as $regex => $page) {
    $regex = '^' . str_replace('/', '\/', $regex) . '(\/)?(\?[a-zA-Z0-9]+=.*)?$';
    if (preg_match("/$regex/i", $_SERVER['REQUEST_URI'], $matches)) {
        $page_found = true;
        $gab->run($page, $matches, $user_id, $user_email_hash, $user_name, $user_badges);
        break;
    }
}

if (!$page_found) echo "Not found";