<?php

session_start();

require_once "api/facebook/FacebookRequestException.php";
require_once "api/facebook/FacebookAuthorizationException.php";
require_once "api/facebook/FacebookRedirectLoginHelper.php";
require_once "api/facebook/FacebookResponse.php";
require_once "api/facebook/FacebookRequest.php";
require_once "api/facebook/FacebookSession.php";
require_once "api/facebook/FacebookSDKException.php";
require_once "api/facebook/GraphObject.php";
require_once "api/facebook/GraphUser.php";

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;

FacebookSession::setDefaultApplication($config['social']['facebook']['appid'], $config['social']['facebook']['appsecret']);

$helper = new FacebookRedirectLoginHelper('http://localhost/friend/');
$session = $helper->getSessionFromRedirect();
if(!$session)
   header("Location: {$helper->getLoginUrl()}", true, 302);

if($session) {

  try {

    $user_profile = (new FacebookRequest(
      $session, 'GET', '/me'
    ))->execute()->getGraphObject(GraphUser::className());

    //入庫，寫Session，跳轉回前頁

  } catch(FacebookRequestException $e) {

    //顯示錯誤頁。
    echo "Exception occured, code: " . $e->getCode();
    echo " with message: " . $e->getMessage();

  }   

}

