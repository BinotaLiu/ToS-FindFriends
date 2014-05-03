<?php

session_start();

require_once "Facebook/FacebookRequestException.php";
require_once "Facebook/FacebookAuthorizationException.php";
require_once "Facebook/FacebookRedirectLoginHelper.php";
require_once "Facebook/FacebookResponse.php";
require_once "Facebook/FacebookRequest.php";
require_once "Facebook/FacebookSession.php";
require_once "Facebook/FacebookSDKException.php";
require_once "Facebook/GraphObject.php";
require_once "Facebook/GraphUser.php";

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;

FacebookSession::setDefaultApplication('647789751957229','4be755661cfac1a710a0bf692e063cfd');

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

