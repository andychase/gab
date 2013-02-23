<?php

function gab_openid_callback($gab) {
    require_once(dirname(__FIlE__).'/openid_lib.php');
    # Change 'localhost' to your domain name.
    $openid = new LightOpenID('test.co');
    if(!$openid->mode) {
        if(isset($_REQUEST['openid_identifier'])) {
            $openid->identity = $_REQUEST['openid_identifier'];
            header('Location: ' . $openid->authUrl());
        }
    } elseif($openid->mode == 'cancel') {
        echo 'User has canceled authentication!';
    } else {
        if($openid->validate())  {
            $_SESSION['user_logged_in'] = $openid->identity;
            $gab->assign('logged_in', 'true');
            $gab->assign('user_logged_in', 'true');
            header('Location: /');
            exit;
        }
        else
            echo "Not logged in";
    }
}


session_start();
if ($_SESSION['user_logged_in']) {
    $this->assign('logged_in', true);
    $this->assign('user_logged_in', $user_id);
}

$this->assign("openid-selector", dirname(__FIlE__)."/openid-selector/demo.html");
$this->addTemplate("all_posts", "add_login.tpl");
$this->extension_pages['openid'] = 'gab_openid_callback';
