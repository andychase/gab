<?php
/**
 * Groups configuration for default Minify implementation
 * @package Minify
 */

/** 
 * You may wish to use the Minify URI Builder app to suggest
 * changes. http://yourdomain/min/builder/
 *
 * See http://code.google.com/p/minify/wiki/CustomSource for other ideas
 **/

if ($_GET['g'] && is_file("groups".DIRECTORY_SEPARATOR.$_GET['g']))
    return unserialize(file_get_contents("groups".DIRECTORY_SEPARATOR.$_GET['g']));