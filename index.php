<?php
/*

CREATE TABLE IF NOT EXISTS `forum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('post','reply','message','category','vote','user') NOT NULL,
  `reply_to` int(11) DEFAULT NULL,
  `author` int(11) NOT NULL,
  `author_email_hash` varchar(32) NOT NULL,
  `author_name` varchar(45) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(80) DEFAULT NULL,
  `message` varchar(5000) NOT NULL,
  `views` int(11) NOT NULL,
  `last_activity` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reply_to` (`reply_to`),
  KEY `message` (`message`(767))
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE `forum`
  ADD CONSTRAINT `forum_ibfk_1` FOREIGN KEY (`reply_to`) REFERENCES `forum` (`id`)
  ON DELETE SET NULL ON UPDATE CASCADE;

*/
$live = false; // SET TO TRUE WHEN LIVE

if($live) ini_set('display_errors','off');
else ini_set('display_errors','on');

if($live) $GLOBALS['baseurlhost'] = "gab.asperous.us";
else $GLOBALS['baseurlhost'] = "test.co";

// PDO
$pdo = new PDO("mysql:host=localhost;dbname=gab", /*Username:*/"gab", /*Password:*/"");
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$GLOBALS['pdo'] = $pdo;


$SMARTY_DIR = "smarty";
require_once('smarty/Smarty.class.php');
require_once("gab.php");

// Smarty
$smarty = new Smarty;
$smarty->setCompileDir('smarty/compile');
$smarty->setCacheDir('smarty/cache');
$smarty->caching = 1;
$smarty->cache_lifetime = 86400;
$compile_check = !$live;

// Gab
$gab = new gab($smarty, $pdo);

// Url Definitions
// Url Regex (Left Side) is routed to a file in controller_folder (Right side)
// Array variable $matches contains url patterns. $matches[1] contains first () group.
$urls = array(
    '/' => 'all_posts',
    '/([0-9]+)' => 'single_post',
    '/new_thread' => 'new_thread',
    '/categories' => 'categories',
    '/category/([a-zA-Z0-9_]+)' => 'single_category',
    '/messages' => 'messages',
    '/ext/([a-zA-Z0-9_]+)' => 'ext',
);

// Run! (Inspired by gluephp.com)
$page_found = false;
foreach ($urls as $regex => $page) {
    $regex = '^' . str_replace('/', '\/', $regex) . '(\/)?(\?[a-zA-Z0-9]+=.*)?$';
    if (preg_match("/$regex/i", $_SERVER['REQUEST_URI'], $matches)) {
        $page_found = true;
        $gab->run($page, $matches, $user_id, $user_email_hash, $user_name);
        break;
    }
}

// If page isn't found
if (!$page_found) echo "Not found";