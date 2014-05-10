<?php
/*
 * Filename: login.php
 * $Id$
 * 登入模組，用於使用社群帳號登入。
 */

define('IN_MOUGE', true);

session_start();
set_time_limit(60);

require_once 'config.inc.php';
require_once 'src/database.php';

require_once 'api/persona/persona.php';

require_once "api/facebook/FacebookRequestException.php";
require_once "api/facebook/FacebookAuthorizationException.php";
require_once "api/facebook/FacebookRedirectLoginHelper.php";
require_once "api/facebook/FacebookResponse.php";
require_once "api/facebook/FacebookRequest.php";
require_once "api/facebook/FacebookServerException.php";
require_once "api/facebook/FacebookSession.php";
require_once "api/facebook/FacebookSDKException.php";
require_once "api/facebook/GraphObject.php";
require_once "api/facebook/GraphUser.php";

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;

$db = new Database;
$db->connect($config['database']['host'], $config['database']['user'], $config['database']['passwd']);
$db->select($config['database']['name']);

//检查用户登录状态
if(!empty($_SESSION['user_id']) && !empty($_SESSION['user_token'])){
  $checkToken = md5($config['secret']['key'][1] . md5($_SESSION['user_id'] . $config['secret']['key'][0]));
  if($_SESSION['user_token'] == $checkToken)
    $loginStatus = 1;
  else{
    $loginStatus = 0;
    unset($_SESSION['user_id']);
    unset($_SESSION['user_token']);
    unset($_SESSION['user_name']);
  }
}else{
  $loginStatus = 0;
}

$data['title'] = "登入 - 徵戰友 | TOS123 - Powered by MouGE";
$data['nav_title'] = "徵戰友";
if($loginStatus){
  $data['uid'] = $_SESSION['user_id'];
  $data['userName'] = $_SESSION['user_name'];
}

if($loginStatus && !empty($_GET['logout']) && $_GET['logout']){
  //銷毀 SESSION，提示登出。
  $data['url'] = $config['system']['basicurl'];
  $data['notice'] = "已登出！感謝您的使用，正在回到首頁";
  $loginStatus = 0;
  unset($_SESSION['user_id']);
  unset($_SESSION['user_token']);
  unset($_SESSION['user_name']);
  unset($_SESSION['login_method']);
  unset($_SESSION['email']);
  unset($_SESSION['card']);
  $_SESSION['user_token'] = "Logged out.";
  setcookie('MOUGESESSID', '', time()-60*60*24*360*4);
  include 'views/header.php';
  include 'views/redirect.php';
  include 'views/footer.php';
  die();
}

if($loginStatus){
  $data['url'] = $config['system']['basicurl'];
  $data['notice'] = "您已登入！無需重複登入，正在回到首頁";
  include 'views/header.php';
  include 'views/redirect.php';
  include 'views/footer.php';
  die();
}

if($_GET['method'] == "persona"){
  if (isset($_POST['assertion'])) {
    $persona = new Persona();
    $result = $persona->verifyAssertion($_POST['assertion']);

    if ($result->status === 'okay') {
      //檢查用戶是否存在
      $db_result = $db->fetch_where('user', array('*'), array('email'  => $result->email));
      if(!$db_result){
        $name = split("@", $result->email)[0];
        $uid  = $db->insert('user', array('nickname' => $name, 'email' => $result->email, 'regtime' => time()));
        $redirectUrl = $config['system']['basicurl'] . "setting.php";
      } else {
        $db->update('user', array('lastlogin' => time()), array('uid' => $db_result[0]['uid']));
        $uid  = $db_result[0]['uid'];
        $name = $db_result[0]['nickname'];
        $redirectUrl = $config['system']['basicurl'];
      }

      $_SESSION['user_id']      = $uid;
      $_SESSION['user_token']   = md5($config['secret']['key'][1] . md5($uid . $config['secret']['key'][0]));
      $_SESSION['user_name']    = $name;
      $_SESSION['email']        = "'$result->email'";
      $_SESSION['login_method'] = 'persona';
      $_SESSION['user_level']   = $db_result[0]['user_level'];

      $data['url'] = $redirectUrl;
      $data['notice'] = "登入成功，正在回到首頁";
      include 'views/header.php';
      include 'views/redirect.php';
      include 'views/footer.php';
    } else {
      //先銷毀Cookie：
      unset($_SESSION['user_id']);
      unset($_SESSION['user_token']);
      unset($_SESSION['user_name']);
      unset($_SESSION['login_method']);
      unset($_SESSION['email']);

      $data['url'] = $config['system']['basicurl'];
      $data['notice'] = "錯誤，詳細訊息：" . $result->reason;
      include 'views/header.php';
      include 'views/redirect.php';
      include 'views/footer.php';
    }
  } else {
    $data['url'] = $config['system']['basicurl'];
    $data['notice'] = "錯誤，正在回到首頁";
    include 'views/header.php';
    include 'views/redirect.php';
    include 'views/footer.php';
  }
} else {
  try{
    FacebookSession::setDefaultApplication(
        $config['social']['facebook']['appid'],
        $config['social']['facebook']['appsecret']);
    $helper = new FacebookRedirectLoginHelper($config['social']['facebook']['redirect']);
  } catch(FacebookRequestException $e){
    $data['url'] = $config['system']['basicurl'];
    $data['notice'] = "載入 Facebook SDK 時發生錯誤，錯誤訊息：<br>" . $e;
    include 'views/header.php';
    include 'views/redirect.php';
    include 'views/redirect.php';
  }
  $session = $helper->getSessionFromRedirect();

  if($session){
    try {
      $user_profile = (new FacebookRequest(
        $session, 'GET', '/me'
      ))->execute()->getGraphObject(GraphUser::className());
      $result = $db->fetch_where('user',array('*'), array('facebook_id'=>$user_profile->getId()));
      if(!$result){
        $uid  = $db->insert('user', array(
                                      'nickname' => $user_profile->getName(),
                                   'facebook_id' => $user_profile->getId(),
                                       'regtime' => time() ));
        $name = $user_profile->getName();
        $redirectUrl = $config['system']['basicurl'] . "setting.php";
      }else{
        $db->update('user', array('lastlogin'=>time()), array('uid'=>$result[0]['uid']));
        $uid  = $result[0]['uid'];
        $name = $result[0]['nickname'];
        $redirectUrl = $config['system']['basicurl'];
      }

      $_SESSION['user_id']      = $uid;
      $_SESSION['user_token']   = md5($config['secret']['key'][1] . md5($uid . $config['secret']['key'][0]));
      $_SESSION['user_name']    = $name;
      $_SESSION['login_method'] = 'facebook';
      $_SESSION['user_level']   = $result[0]['user_level'];

      $data['url'] = $redirectUrl;
      $data['notice'] = "登入成功，正在回到首頁";
    } catch(FacebookRequestException $e) {
      $data['url'] = $config['system']['basicurl'];
      $data['notice'] = "發生錯誤，代碼 " . $e->getCode() . "，詳細訊息<br>" . $e->getMessage();
    }//catch

    include 'views/header.php';
    include 'views/redirect.php';
    include 'views/footer.php';
  }else{
    header("Location: {$helper->getLoginUrl()}", true, 302);
  }
}

