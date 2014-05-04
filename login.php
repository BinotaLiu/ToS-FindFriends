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

if($_GET['method'] == "persona"){
  $body = $email = NULL;
if (isset($_POST['assertion'])) {
    $persona = new Persona();
    $result = $persona->verifyAssertion($_POST['assertion']);

    if ($result->status === 'okay') {
        $body = "<p>Logged in as: " . $result->email . "</p>";
        $body .= '<p><a href="javascript:navigator.id.logout()">Logout</a></p>';
        $email = $result->email;
    } else {
        $body = "<p>Error: " . $result->reason . "</p>";
    }
    $body .= "<p><a href=\"testPersona.php\">Back to login page</a></p>";
} elseif (!empty($_GET['logout'])) {
    $body = "<p>You have logged out.</p>";
    $body .= "<p><a href=\"testPersona.php\">Back to login page</a></p>";
} else {
    $body = "<p><a class=\"persona-button\" href=\"javascript:navigator.id.request()\"><span>Login with Persona</span></a></p>";
}
  echo <<<_PERSONA
<!DOCTYPE html>
<html>
<head><meta http-equiv="X-UA-Compatible" content="IE=Edge">
<link rel="stylesheet" type="text/css" href="css/persona-buttons.css"
</head>
<body>
<form id="login-form" method="POST" action="testPersona.php">
<input id="assertion-field" type="hidden" name="assertion" value="">
</form>
$body
<script src="https://login.persona.org/include.js"></script>
<script>
navigator.id.watch({
loggedInUser:
_PERSONA;
  echo $email ? "'$email'" : 'null';
echo <<<_PERSONA
,
onlogin: function (assertion) {
var assertion_field = document.getElementById("assertion-field");
assertion_field.value = assertion;
var login_form = document.getElementById("login-form");
login_form.submit();
},
onlogout: function () {
window.location = '?logout=1';
}
});
</script>
</body>
</html> 
_PERSONA;
} else {
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
      $result = $db->fetch_where('user',array('*'), array('facebook_id'=>$user_profile->getId()));
      if(!$result)
        $uid = $db->insert('user', array('nickname'=>$user_profile->getName(),'facebook_id'=>$user_profile->getId(),'regtime'=>time()));
      else{
        $db->update('user', array('lastlogin'=>time()), array('uid'=>$result[0]['uid']));
        $uid = $result[0]['uid'];
      }

      $_SESSION['user_id']    = $uid;
      $_SESSION['user_token'] = md5($config['secret']['key'][1] . md5($uid . $config['secret']['key'][0]));

      header('Location: /friend', 302);
    } catch(FacebookRequestException $e) {
      //顯示錯誤頁。
      echo "Exception occured, code: " . $e->getCode();
      echo " with message: " . $e->getMessage();
    }//catch
  }//if
}

