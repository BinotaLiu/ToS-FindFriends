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

include 'views/header.php';
include 'views/main_search.php';

if($loginStatus){
  //先抓自己的代表資訊：
  if(empty($_SESSION['card'])){
    $myCard = $db->fetch_where('user_card', array('*'), array('uid' => $data['uid']));
    if($myCard){
      $cardInfo = $db->fetch_where('card', array('*'), array('card_id' => $myCard[0]['card_id']));
      $_SESSION['card']['card_id'] = $myCard[0]['card_id'];
      $_SESSION['card']['name'] = $cardInfo[0]['card_name'];
      $_SESSION['card']['card_level'] = $myCard[0]['card_level'];
      $_SESSION['card']['skill_level'] = $myCard[0]['skill_level'];
      $_SESSION['card']['detail'] = $myCard[0]['detail'];
    }else{
      //還沒登錄過代表資訊：
      $_SESSION['card']['card_id'] = 0;
      $_SESSION['card']['name'] = "尚未登錄代表";
      $_SESSION['card']['card_level'] = "0";
      $_SESSION['card']['skill_level'] = "0";
      $_SESSION['card']['detail'] = "若要登錄代表，請點擊下方「編輯我的代表資訊」。";
    }
    $data['card'] = $_SESSION['card'];
  }else{
    $data['card'] = $_SESSION['card'];
  }
  include 'views/main_loggedin.php';
}else
  include 'views/main_nologin.php';

$data['topic'] = $db->query('SELECT `tid`, `time`, `title`, `content`' .
                            'FROM `official_topic`' .
                            'ORDER BY -`time`');
include 'views/main_official-topic.php';

include 'views/footer.php';

