<?php

function gab_successful_login($user_title, $gab) {
    $baseurl = $gab->base_url;
    $user = user::get_user($user_title);
    $user_ext = user::get_user_ext($user['id']);
    $_SESSION['user_trust'] = $user_ext['trust'];
    $_SESSION['user_title'] = $user_title;
    if (empty($user)) {
        header("Location: {$baseurl}/ext/openid_signup");
        exit;
    }
    $_SESSION['user_logged_in'] = $user['id'];
    $_SESSION['user_name'] = $user['author_name'];
    $_SESSION['user_email_hash'] = $user['author_email_hash'];
    $gab->assign('logged_in', 'true');
    $gab->assign('user_logged_in', 'true');
    header("Location: {$baseurl}/");
    exit;
}

function gab_openid_callback($gab) {
    require_once(dirname(__FIlE__).'/openid_lib.php');
    # Change 'localhost' to your domain name.
    $openid = new LightOpenID($GLOBALS['baseurlhost']);
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
    $_SESSION['user_trust'] = "";
    $gab->assign('logged_in', false);
    $gab->assign('user_logged_in', "");
    $gab->assign('user_trust', "");
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
        $user_id = user::new_user($_SESSION['user_title'], trim($_POST['name']), md5(strtolower(trim($_POST['email']))));
        if (user::just_inserted_first_user()) {
            // First user on forum is lvl 99 moderator.
            $ext = user::get_user_ext_lock($user_id);
            $ext['trust'] = 99;
            user::set_user_ext($user_id, $ext);
        }
        $gab->clearCache('users');
        gab_successful_login($_SESSION['user_title'], $gab);
    }
}

session_set_cookie_params(0);
session_start();
if ($_SESSION['user_logged_in']) {
    $this->assign('logged_in', true);
    $this->assign('user_logged_in', $_SESSION['user_logged_in']);
    $this->assign('user_trust', $_SESSION['user_trust']);
    $this->addCacheId($_SESSION['user_logged_in']);
}

$this->assign("openid-selector", dirname(__FIlE__)."/openid-selector/demo.html");
$this->addJavascript("openid-selector/js/openid-jquery.js");
$this->addJavascript("openid-selector/js/openid-en.js");
$this->addJavascript("openid-activate.js");
$this->addCss("openid-selector/css/openid.css");
$this->addTemplate("*", "add_login.tpl");
$this->addPage('openid', 'gab_openid_callback');
$this->addPage('openid_logout', 'gab_openid_logout');
$this->addPage('openid_signup', 'gab_setup_account');
