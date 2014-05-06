<?php
/*
 * Filename: setting.php
 * $Id$
 * 設定頁，用於提供使用者進行設定。
 */
define('IN_MOUGE', true);

session_start();

require_once 'config.inc.php';
require_once 'src/database.php';

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

$data['title'] = "徵戰友 | 遇見先鋒 - Powered by MouGE";
$data['nav_title'] = "徵戰友";
if($loginStatus){
  $data['uid'] = $_SESSION['user_id'];
  $data['userName'] = $_SESSION['user_name'];
}

if(!$loginStatus) {
  $data['url'] = $config['system']['basicurl'];
  $data['notice'] = "請先登入";
  include 'views/header.php';
  include 'views/redirect.php';
  include 'views/footer.php';
  die();
}

$myInfo = $db->fetch_where('user', array('*'), array('uid' => $data['uid']));

if($myInfo[0]['facebook_id'])
  $data['form']['loginmethod'] = "Facebook (UID:" . $myInfo[0]['facebook_id'] . ")";
else
  $data['form']['loginmethod'] = "Persona (E-Mail: " . $myInfo[0]['email'] . ")";

if(!empty($_POST['nickname'])){
  $db->update('user', array('nickname' => $_POST['nickname']), array('uid' => $data['uid']));
  $fixed_nickname = $db->fix_string($_POST['nickname']);
  $data['form']['nickname'] = $fixed_nickname;
  //复写SESSION 中的资讯：
  $_SESSION['user_name'] = $fixed_nickname;
  $data['userName'] = $fixed_nickname;
}else
  $data['form']['nickname'] = $myInfo[0]['nickname'];

include 'views/header.php';
include 'views/setting.php';
include 'views/footer.php';

