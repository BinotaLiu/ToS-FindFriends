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

require_once 'cards.inc.php';

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

$data['title'] = "徵戰友 | 遇見先鋒 - Powered by MouGE";
$data['nav_title'] = "徵戰友";
if($loginStatus){
  $data['uid'] = $_SESSION['user_id'];
  $data['userName'] = $_SESSION['user_name'];
}

//先看看要查詢的東西：
$page = empty($_GET['page']) ? 0 : intval($_GET['page']) - 1;
$keyword = empty($_GET['keyword']) ? "" : $db->fix_string($_GET['keyword']);
$card = empty($_GET['card']) ? "" : $db->fix_string($_GET['card']);
if(!empty($_GET['keyword'])){
  //先找卡片名稱：
  $findCardsName = $db->query("SELECT `card_id` FROM `card` WHERE `card_name` REGEXP '.*" . $db->fix_string($_GET['keyword']) . ".*'");
  $queryCardName = "";
  foreach($findCardsName as $value)
    $queryCardName .= " `card_id` = " . $value[0] . " or";
  $queryCardName = substr($queryCardName, 0, -2);

  //查資料：
  $data['searchName'] = "包含「" . $db->fix_string($_GET['keyword']) . "」的卡片";
  $data['dbResult'] = $db->query(
                             "SELECT * FROM `user_card` " . 
                             "WHERE `logtime` >= " . (intval(time()) - (60*60*24*60)) . " and" . $queryCardName .
                             "ORDER BY -`logtime` " .
                             "LIMIT " . $page*10 . ", 10");
  $data['totalCount'] = $db->query(
                             "SELECT COUNT(*) FROM `user_card` " . 
                             "WHERE `logtime` >= " . (intval(time()) - (60*60*24*60)) . " and" . $queryCardName . 
                             "LIMIT " . $page*10 . ", 10")[0][0];
  //總頁數 = 總數/10 後無條件進入
  $data['totalPage'] = ceil($data['totalCount'] / 10);
  if($data['dbResult'])
  foreach($data['dbResult'] as $count => $value){
    $data['cardName'][$count] = $cardInfo[$value['card_id']]['cardName'];
  }
  $data['usersName'] = array();
  $data['second']    = array();
  if($data['dbResult'])
  foreach($data['dbResult'] as $user){
    $data['usersName'][] = $db->fetch_where('user', array('nickname'), array('uid' => $user['uid']))[0]['nickname'];
    $data['second'][]    = $db->fetch_where('user_card_second', array('*'), array('uid' => $user['uid']))[0];
  }
}else if(!empty($_GET['card'])){
  if($page < 0) $page = 0;
  if(!empty($_GET['card'])){
    $card_id = intval($_GET['card']);
    //先抓卡片名稱
    $data['searchName'] = $cardInfo[$card_id]['cardName'];
    $data['dbResult'] = $db->query(
                               "SELECT * FROM `user_card` " . 
                               "WHERE `logtime` >= " . (intval(time()) - (60*60*24*60)) . " and " .
                                     "`card_id` = " . $card_id . " " .
                               "ORDER BY -`logtime` " .
                               "LIMIT " . $page*10 . ", 10");
    $data['totalCount'] = $db->query(
                               "SELECT COUNT(*) FROM `user_card` " . 
                               "WHERE `logtime` >= " . (intval(time()) - (60*60*24*60)) . " " . 
                               "LIMIT " . $page*10 . ", 10")[0][0];
    $data['totalPage']  = ceil($data['totalCount'] / 10);
    for($i=0;$i<4;$i++) $data['cardName'][$i] = $data['searchName'];
    $data['usersName'] = array();
    $data['second']  = array();
    if($data['dbResult'])
    foreach($data['dbResult'] as $user){
      $data['usersName'][] = $db->fetch_where('user', array('nickname'), array('uid' => $user['uid']))[0]['nickname'];
      $data['second'][]    = $db->fetch_where('user_card_second', array('*'), array('uid' => $user['uid']))[0];
    }
  }
}else {
  //輸出錯誤頁
}

include 'views/header.php';
include 'views/search.php';
include 'views/footer.php';

