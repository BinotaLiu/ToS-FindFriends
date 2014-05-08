<?php
/*
 * Filename: index.php
 * $Id$
 * 首頁，所有模組從此連結。
 */
define('IN_MOUGE', true);

session_start();

require_once 'config.inc.php';
require_once 'src/database.php';

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
  unset($_SESSION['login_method']);
  unset($_SESSION['email']);
  unset($_SESSION['card']);
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

$data['error'] = "發生錯誤了，暫時沒辦法完成您的要求，要不要先找找戰友啊？";
include 'views/header.php';
include 'views/error.php';
include 'views/footer.php';
