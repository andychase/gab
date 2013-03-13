# How to make an extension

1. Make directory titled with a category & name. Example: theme_silicone
2. Make php file inside directory with the same name as that directory. Example: theme_silicone.php
3. Add gab api calls that extend gab.

## Categories

- theme_ -- Look & Feel (Anything w/ mostly css & images)
- feat_ -- Major feature (Anything that adds pages)
- ux_   -- Small user experience nicety
- misc_ -- Cosmetic details unrelated to a specific theme
- hook_ -- Integration with other services
- parser_ -- Anything that transform posts output when they are displayed
- search_ -- Anything that requires the search service extension
- lang_ -- Language packs (should mostly extend templates, possibly css & js)
- pack_ -- A bundle of other extensions above

## Api

- ``$this->addController($page, $controller_name, [$order=""])``
- ``$this->addPage($page, $callback_function)``
- ``$this->addSmartyPlugin($plugin_type, $plugin_name, $function_name)``
- ``$this->addTemplate($page, $template_name, [$order=""])``
- ``$this->addJavascript($name, [$order=""])``
- ``$this->addCss($name)``
- ``$gab->displayGeneric($template_name)`` - Push ``$template_name`` to the stack for "posts" and display it. ($template_name is relative to your extension path)

``$page``

- "*" -- Shortcut for adding something to all pages
- "posts" -- All the threads or posts in all categories (the homepage)
- "single_post" -- All the replies to one post (or thread)
- "categories" -- A list of all the categories
- "single_category" -- One category: its description and posts (or threads)
- "messages" -- Your mentions and watched posts/thread updates
- "single_user" -- The profile of one user
- "users" -- A directory of all the users

``$order``

- ``"pre"`` -- Added to beginning, or just after the base template for addTemplate
- ``""`` -- Added to the end.

No order is guaranteed among extensions, but the order inside each extension will be honored.

``$name`` -- file name inside of your directory of your extension.

``$this->addPage`` -- When ``/ext/$page`` is accessed, calls ``$callback_function``
This is a string that names a function. This function must accept a ``$gab``
parameter that contains the gab object. See feat_openid for more an example.

## Example

*(You can also download approved extensions and look at them for more examples)*

Say you have a directory like this:

    \---ux_timeago
           timeago.tpl
           ux_timeago.php

Your ``ux_timeago.php`` file will look like this:

    function smarty_modifier_timeAgo($date)
    {...}

    $this->addSmartyPlugin("modifier", "timeAgo", "smarty_modifier_timeAgo");
    $this->addTemplate('single_post', 'timeago.tpl');








