<?php
/*
 * Filename: mycard.php
 * $Id$
 * 檢視我的卡片資訊。
 */
define('IN_MOUGE', true);

session_start();

require_once 'config.inc.php';
require_once 'src/database.php';

$db = new Database;
$db->connect($config['database']['host'], $config['database']['user'], $config['database']['passwd']);
$db->select($config['database']['name']);

if(!empty($_SESSION['user_id']) && !empty($_SESSION['user_token'])){
  $checkToken = md5($config['secret']['key'][1] . md5($_SESSION['user_id'] . $config['secret']['key'][0]));
  if($_SESSION['user_token'] == $checkToken)
    $loginStatus = 1;
  else{
    $loginStatus = 0;
  unset($_SESSION['user_id']);
  unset($_SESSION['user_token']);
  unset($_SESSION['user_name']);
  unset($_SESSION['login_method']);
  unset($_SESSION['email']);
  unset($_SESSION['card']);
  }
}else{
  $loginStatus = 0;
}

$data['title'] = "編輯代表 - 徵戰友 | TOS123 - Powered by MouGE";
$data['nav_title'] = "徵戰友";
if($loginStatus){
  $data['uid'] = $_SESSION['user_id'];
  $data['userName'] = $_SESSION['user_name'];
}
$data['success'] = false;
$data['expire'] = false;

if(!$loginStatus) {
  $data['url'] = $config['system']['basicurl'];
  $data['notice'] = "請先登入";
  include 'views/header.php';
  include 'views/redirect.php';
  include 'views/footer.php';
  die();
}

include 'views/header.php';
include 'views/footer.php';

