<?php

$forum_id = 1;
$pdo = new pdo('mysql:host=localhost;dbname=gab_test', /*Username:*/'root', /*Password:*/'');
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$schema = explode(";", file_get_contents("models/schema.sql"));
$pdo->exec($schema[0]);
