<?php

function gab_successful_login($user_title, $gab) {
    session_set_cookie_params(0);
    session_start();
    $baseurl = $gab->base_url;
    $user = user::get_user(null, null, $user_title);
    $_SESSION['badges'] = $user['badges'];
    $_SESSION['user_title'] = $user_title;
    if (empty($user)) {
        header("Location: {$baseurl}/ext/openid_signup");
        exit;
    }
    $_SESSION['user_logged_in'] = $user['id'];
    $_SESSION['user_name'] = $user['author_name'];
    $_SESSION['user_email_hash'] = $user['author_email_hash'];
    $_SESSION['forum_id'] = $GLOBALS['forum_id'];
    $gab->assign('logged_in', 'true');
    $gab->assign('user_logged_in', 'true');
    header("Location: {$baseurl}/");
    exit;
}

function gab_openid_callback($gab) {
    require_once(dirname(__FIlE__).'/openid_lib.php');
    # Change 'localhost' to your domain name.
    $openid = new LightOpenID($_SERVER['SERVER_NAME']);
    if(!$openid->mode) {
        if(isset($_REQUEST['openid_identifier'])) {
            $openid->identity = $_REQUEST['openid_identifier'];
            header('Location: ' . $openid->authUrl());
        }
    } elseif($openid->mode == 'cancel') {
        echo 'User has canceled authentication!';
    } else {
        if($openid->validate())
            gab_successful_login($openid->identity, $gab);
        else
            echo "Not logged in";
    }
}

function gab_openid_logout($gab) {
    $_SESSION['user_logged_in'] = "";
    $_SESSION['user_title'] = "";
    $_SESSION['user_name'] = "";
    $_SESSION['user_email_hash'] = "";
    $_SESSION['badges'] = "";
    setcookie("PHPSESSID", '', time() - 3600, '/');
    header('Location: /');
}

function gab_setup_account($gab) {
    $gab->caching = 0;
    if (!trim($_POST['name'])) {
        $gab->displayGeneric('signup.tpl');
    } else if (user::exists_user_name(trim($_POST['name']))) {
        $gab->assign("errors", array("That name is already taken"));
        $gab->displayGeneric('signup.tpl');
    } else {
        $email = strtolower(trim($_POST['email']));
        if ($email)
            $email_hash = md5($email);
        else
            $email_hash = md5(uniqid());
        $user_id = user::new_user($_SESSION['user_title'], trim($_POST['name']), $email_hash);
        if (user::just_inserted_first_user())
            // First user on forum is moderator and owner.
            user::add_badge($user_id, 'mod,owner');
        $gab->clearCache('users');
        gab_successful_login($_SESSION['user_title'], $gab);
    }
}

$gab->assign("openid-selector", dirname(__FIlE__)."/openid-selector/demo.html");
$gab->addJavascript("openid-selector/js/openid-jquery.js");
$gab->addJavascript("openid-selector/js/openid-en.js");
$gab->addJavascript("openid-activate.js");
$gab->addCss("openid-selector/css/openid.css");
$gab->addTemplate("*", "add_login.tpl");
$gab->addPage('openid', 'gab_openid_callback');
$gab->addPage('openid_logout', 'gab_openid_logout');
$gab->addPage('openid_signup', 'gab_setup_account');

function prepare_user ($gab) { include 'prepare_user.php'; }
$gab->bindTrigger('*', 'prepare_user');