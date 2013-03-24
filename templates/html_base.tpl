<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <title>{block name='title'}{$forum_name}{/block}</title>
    <meta name="description" content="{$forum_desc|trim}" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link rel="stylesheet" type="text/css" href="{$css_url}" />
    <script type="text/javascript" src="{$js_url}"></script>

    {block name='head'}{/block}
</head>
<body>
{block 'body'}{/block}
</body>
</html>