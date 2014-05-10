<?php
/*
 * Filename: topic.php
 * $Id$
 * 公告，用於檢視網站公告。
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
  unset($_SESSION['login_method']);
  unset($_SESSION['email']);
  unset($_SESSION['card']);
  }
}else{
  $loginStatus = 0;
}

if(!empty($_GET['tid'])){
  //抓取 topic
  $result = $db->fetch_where('official_topic', array('*'), array('tid' => $_GET['tid']));
  if(!empty($result)){
    $data['topic'] = $result[0];
    //抓 Username
    $data['topic']['author_name'] = $db->fetch_where('user', array('nickname'), array('uid' => $data['topic']['author']))[0]['nickname'];
    $data['title'] = $data['topic']['title'] . " - 公告 - 徵戰友 | TOS123 - Powered by MouGE";
    $data['nav_title'] = "徵戰友";
    if($loginStatus){
      $data['uid'] = $_SESSION['user_id'];
      $data['userName'] = $_SESSION['user_name'];
    }

    include 'views/header.php';
    include 'views/topic_content.php';
  }else{
    $data['title'] = "公告 - 徵戰友 | 遇見先鋒 - Powered by MouGE";
    $data['nav_title'] = "徵戰友";
    if($loginStatus){
      $data['uid'] = $_SESSION['user_id'];
      $data['userName'] = $_SESSION['user_name'];
    }

    include 'views/header.php';
    include 'views/topic_notfound.php';
  }
}else{
  //表示無此topic
  $data['title'] = "公告 - 徵戰友 | 遇見先鋒 - Powered by MouGE";
  $data['nav_title'] = "徵戰友";
  if($loginStatus){
    $data['uid'] = $_SESSION['user_id'];
    $data['userName'] = $_SESSION['user_name'];
  }
  include 'views/header.php';
  include 'views/topic_notfound.php';
}

include 'views/footer.php';

