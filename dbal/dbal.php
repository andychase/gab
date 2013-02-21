<?php

use Doctrine\Common\ClassLoader;
require_once 'dbal/Doctrine/Common/ClassLoader.php';
$classLoader = new ClassLoader('Doctrine', 'dbal');
$classLoader->register();

$config = new \Doctrine\DBAL\Configuration();

$dbal = \Doctrine\DBAL\DriverManager::getConnection(array('pdo' => $pdo), $config);
$GLOBALS['dbal'] = $dbal;