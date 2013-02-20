<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <title>{block name='title'}Gab Test{/block}</title>
    <meta name="description" content="Embeddable, Extendable, Minimal next-gen forum software that's easy to deploy." />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <link rel="stylesheet" type="text/css" href="{$assets_url}/gab.css" />
    <script type="text/javascript" src="{$assets_url}/jquery.js"></script>
    <script type="text/javascript" src="{$assets_url}/jquery.cookie.js"></script>
    <script type="text/javascript" src="{$assets_url}/markdown.js"></script>
    <script type="text/javascript" src="{$assets_url}/hash.js"></script>
    <script type="text/javascript" src="{$assets_url}/script.js"></script>

    <link href='http://fonts.googleapis.com/css?family=Knewave' rel='stylesheet' type='text/css'>

    <style type="text/css">
        body {
            width: 600px;
            margin-left: auto;
            margin-right: auto;
            margin-top: 125px;
        }
        h1 {
            font-family: "Knewave", sans-serif;
            font-size: 72pt;
            color: black;
            text-shadow: 0px 2px 5px black;

        }
        h1 a {
            color: black; text-decoration: none;
            text-shadow: none;
        }
        h1 a:visited { color: black;}
    </style>
{block name='head'}{/block}
</head>
<body>

<h1><a href="">Gab</a></h1>

{block 'body'}{/block}

</body>
</html>