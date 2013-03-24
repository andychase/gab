<?php

$user_name = trim(urldecode($matches[1]));
$this->addCacheId($user_name);

if ($_POST['do']) {
    switch ($_POST['do']) {
        case 'deletemod':
            if ($this->user->hasPermission(permission::ASSIGN_MODS))
                user::remove_badge(intval($_POST['user']), 'mod');
            break;
        case 'makemod':
            if ($this->user->hasPermission(permission::ASSIGN_MODS))
                user::add_badge(intval($_POST['user']), 'mod');
            break;
        case 'ban':
            if ($this->user->hasPermission(permission::BAN))
                user::ban(intval($_POST['user']));
            $this->clearCache('users');
            break;
        case 'unban':
            if ($this->user->hasPermission(permission::BAN))
                user::ban(intval($_POST['user']), true);
            $this->clearCache('users');
            break;
    }

    $this->clearCache('single_user', $user_name);
    header('Location: '.$_SERVER['REQUEST_URI']);
    $this->redirect = true;
}


if (!$this->isCached()) {
    $user = user::get_user(null, $user_name);
    $this->assign("user", $user);
    $this->assign("user_name", $user_name);
    $this->assign("forum_section", "users");

    $this->assign("user_posts", user::get_user_posts($user['id']));
}