<?php
/*
 * Filename: search.php
 * $Id$
 * 搜尋，用於找卡片。
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

//先看看要查詢的東西：
$page = empty($_GET['page']) ? 0 : intval($_GET['page']) - 1;
if(!empty($_GET['keyword'])){
  //先找卡片名稱：
  $findCardsName = $db->query("SELECT `card_id` FROM `card` WHERE `card_name` REGEXP '.*" . $db->fix_string($_GET['keyword']) . ".*'");
  $queryCardName = "";
  foreach($findCardsName as $value)
    $queryCardName .= " `card_id` = " . $value[0] . " or";
  $queryCardName = substr($queryCardName, 0, -3);

  //查資料：
  $data['cardName'] = "包含「" . $db->fix_string($_GET['keyword']) . "」的卡片";
  $data['dbResult'] = $db->query("SELECT * FROM `user_card` WHERE" . $queryCardName . " LIMIT " . $page*10 . ", 10");
  $data['usersName'] = array();
  foreach($data['dbResult'] as $user)
    $data['usersName'][] = $db->fetch_where('user', array('nickname'), array('uid' => $user['uid']))[0]['nickname'];
}else if(!empty($_GET['card'])){
  if($page < 0) $page = 0;
  if(!empty($_GET['card'])){
    $card_id = intval($_GET['card']);
    //先抓卡片名稱
    $data['cardName'] = $db->fetch_where('card', array('card_name'), array('card_id' => $card_id))[0]['card_name'];
    $data['dbResult'] = $db->fetch_where('user_card', array('*'), array('card_id' => $card_id), $page*10, 10);
    $data['usersName'] = array();
    foreach($data['dbResult'] as $user){
      $data['usersName'][] = $db->fetch_where('user', array('nickname'), array('uid' => $user['uid']))[0]['nickname'];
    }
  }
}else {
  //輸出錯誤頁
}

include 'var/view/header.php';

include 'var/view/search.php';

include 'var/view/footer.php';

