<?php
/*
 * Filename: login.php
 * $Id$
 * 登入模組，用於使用社群帳號登入。
 */

define('IN_MOUGE', true);

session_start();

require_once 'config.inc.php';
require_once 'src/database.php';

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


if(isset($_GET['method'])){
  switch($_GET['method']){
    case 'facebook':
      try{
        FacebookSession::setDefaultApplication($config['social']['facebook']['appid'], $config['social']['facebook']['appsecret']);
        $helper = new FacebookRedirectLoginHelper('http://localhost/friend/login.php?method=facebook');
      } catch(FacebookRequestException $e){
        echo "Error, can't load facebook sdk with following debug infomation: " . $e;
      }
      $session = $helper->getSessionFromRedirect();
      if(!$session)
         header("Location: {$helper->getLoginUrl()}", true, 302); //跳轉至 Facebook 登入頁。

      if($session) {
        try {
          $user_profile = (new FacebookRequest(
            $session, 'GET', '/me'
          ))->execute()->getGraphObject(GraphUser::className());
          echo "Login Method: Facebook<br>";
          echo "User name: " . $user_profile->getName() . "<br>ID: " . $user_profile->getId();
          //入庫，寫Session，跳轉回前頁
        } catch(FacebookRequestException $e) {
          //顯示錯誤頁。
          echo "Exception occured, code: " . $e->getCode();
          echo " with message: " . $e->getMessage();
        }//catch
     }//if
      break; //case 'facebook'
    default:
      echo "Invilid action";
      break; //default
  }//switch
}else{
  echo "Invilid action";
}
