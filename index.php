<?php
/*

CREATE TABLE IF NOT EXISTS `forum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('post','reply','message','category','vote','user') CHARACTER SET latin1 NOT NULL,
  `reply_to` int(11) DEFAULT NULL,
  `author` int(11) NOT NULL,
  `author_email_hash` varchar(32) CHARACTER SET latin1 NOT NULL,
  `author_name` varchar(45) CHARACTER SET latin1 NOT NULL,
  `time_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_last_activity` timestamp NULL DEFAULT NULL,
  `replies` int(11) DEFAULT NULL,
  `title` varchar(80) CHARACTER SET latin1 DEFAULT NULL,
  `message` varchar(5000) CHARACTER SET latin1 DEFAULT NULL,
  `views` int(11) NOT NULL,
  `status` enum('mod_hidden','hidden','closed','normal','important','sticky') NOT NULL DEFAULT 'normal',
  `stats` varchar(300) DEFAULT NULL,
  `ext` varchar(8000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `reply_to` (`reply_to`),
  KEY `message` (`message`(767)),
  KEY `type` (`type`),
  KEY `author` (`author`),
  KEY `views` (`views`),
  KEY `time_last_activity` (`time_last_activity`),
  KEY `status_time` (`status`,`time_last_activity`),
  KEY `replies` (`replies`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `forum`
  ADD CONSTRAINT `forum_ibfk_1` FOREIGN KEY (`reply_to`) REFERENCES `forum` (`id`)
  ON DELETE SET NULL ON UPDATE CASCADE;

*/

// Speed up page loads by zlibing them
ini_set('zlib.output_compression', 4096);

$live = false; // SET TO TRUE WHEN LIVE

if($live) ini_set('display_errors','off');
else ini_set('display_errors','on');

if($live) $GLOBALS['baseurlhost'] = 'gab.asperous.us';
else $GLOBALS['baseurlhost'] = 'test.co';

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
$smarty->cache_lifetime = 86400;
$compile_check = !$live;

// Gab
require_once('gab.php');
$gab = new gab($smarty, $pdo);

// Url Definitions
// Url Regex (Left Side) is routed to a file in controller_folder (Right side)
// Array variable $matches contains url patterns. $matches[1] contains first () group.
$urls = array(
    '/' => 'posts',
    '/([0-9]+)' => 'single_post',
    '/new_thread' => 'new_thread',
    '/categories' => 'categories',
    '/category/([a-zA-Z0-9_]+)' => 'single_category',
    '/messages' => 'messages',
    '/users' => 'users',
    '/user/([a-zA-Z0-9_]+)' => 'single_user',
    '/ext/([a-zA-Z0-9_]+)' => 'ext',
);

// Run! (Inspired by gluephp.com)
$page_found = false;
foreach ($urls as $regex => $page) {
    $regex = '^' . str_replace('/', '\/', $regex) . '(\/)?(\?[a-zA-Z0-9]+=.*)?$';
    if (preg_match("/$regex/i", $_SERVER['REQUEST_URI'], $matches)) {
        $page_found = true;
        $gab->run($page, $matches, $user_id, $user_email_hash, $user_name, $user_trust);
        break;
    }
}

// If page isn't found
if (!$page_found) echo "Not found";