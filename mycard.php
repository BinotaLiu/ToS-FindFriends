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

$card_record = $db->fetch_where('user_card', array('*'), array('uid' => $data['uid']));
$second_record = $db->fetch_where('user_card_second', array('*'), array('uid' => $data['uid']));

if($card_record)
  if(time() - $card_record[0]['logtime'] >= 60*60*24*60)
    $data['expire'] = true;

$data['error'] = "";
//檢查 POST 
if(!empty($_POST['tos_id'])){
  if(substr($_POST['tos_id'], 0, 1) == "9"){
    if(strlen($_POST['tos_id']) != 8){
      $data['error'] = "您的玩家 UID 有誤，請確認<br>";
    }
  }else{
   if(strlen($_POST['tos_id']) != 9)
     $data['error'] = "您的玩家 UID 有誤，請確認<br>";
  }

  if(intval($_POST['card_id']) > 563 || intval($_POST['card_id']) <= 0)
    $data['error'] .= "您選擇的卡片有誤，請確認<br>";

  if(intval($_POST['card_level']) > 99 || intval($_POST['card_level']) <= 0)
    $data['error'] .= "您的卡片等級不正確，請確認<br>";

  if(intval($_POST['skill_level']) > 15 || intval($_POST['skill_level']) <=0)
    if(intval($_POST['skill_level']) != -1)
      $data['error'] = "您的技能等級有誤，請確認";

  //保存入庫
  //檢查是否已有記錄
  if(empty($data['error']) && $card_record){
    //已有記錄 -> Update
    $db->update('user_card', array(
                               'tos_id' => $_POST['tos_id'],
                               'detail' => $_POST['detail'],
                              'card_id' => $_POST['card_id'],
                           'card_level' => $_POST['card_level'],
                          'skill_level' => ($_POST['skill_level'] == -1) ? "MAX" : $_POST['skill_level'],
                              'logtime' => time()), array('uid' => $data['uid']));
  } else {
    $db->insert('user_card', array(
                                  'uid' => $data['uid'],
                               'tos_id' => $_POST['tos_id'],
                               'detail' => $_POST['detail'],
                              'card_id' => $_POST['card_id'],
                           'card_level' => $_POST['card_level'],
                          'skill_level' => ($_POST['skill_level'] == -1) ? "MAX" : $_POST['skill_level'],
                              'logtime' => time()));
  }

  $data['form']['tos_id'] = $_POST['tos_id'];
  $data['form']['detail'] = $_POST['detail'];
  $data['form']['card_id'] = $_POST['card_id'];
  $data['form']['card_level'] = $_POST['card_level'];
  $data['form']['skill_level'] = $_POST['skill_level'];

  //檢查候補資料表
  if($second_record){
    //已有記錄 -> Update
    $db->update('user_card_second', array(
                             'card1_id' => $_POST['card1_id'],
                             'card2_id' => $_POST['card2_id'],
                             'card3_id' => $_POST['card3_id'],
                             'card4_id' => $_POST['card4_id']), array('uid' => $data['uid']));
  }else{
    $db->insert('user_card_second', array(
                                  'uid' => $data['uid'],
                             'card1_id' => $_POST['card1_id'],
                             'card2_id' => $_POST['card2_id'],
                             'card3_id' => $_POST['card3_id'],
                             'card4_id' => $_POST['card4_id']));
  }

  $data['form']['card1_id'] = $_POST['card1_id'];
  $data['form']['card2_id'] = $_POST['card2_id'];
  $data['form']['card3_id'] = $_POST['card3_id'];
  $data['form']['card4_id'] = $_POST['card4_id'];

  $data['success'] = empty($data['error']);
  unset($_SESSION['card']);
} else {
  //無 POST 記錄，直接將資料庫內容寫入表單。
  if($card_record){
    $data['form']['tos_id'] = $card_record[0]['tos_id'];
    $data['form']['detail'] = $card_record[0]['detail'];
    $data['form']['card_id'] = $card_record[0]['card_id'];
    $data['form']['card_level'] = $card_record[0]['card_level'];
    $data['form']['skill_level'] = $card_record[0]['skill_level'];
  } else {
    $data['form']['tos_id'] = "";
    $data['form']['detail'] = "";
    $data['form']['card_id'] = "";
    $data['form']['card_level'] = "";
    $data['form']['skill_level'] = "";
  }
  if($second_record){
    $data['form']['card1_id'] = $second_record[0]['card1_id'];
    $data['form']['card2_id'] = $second_record[0]['card2_id'];
    $data['form']['card3_id'] = $second_record[0]['card3_id'];
    $data['form']['card4_id'] = $second_record[0]['card4_id'];
  } else {
    $data['form']['card1_id'] = "";
    $data['form']['card2_id'] = "";
    $data['form']['card3_id'] = "";
    $data['form']['card4_id'] = "";
  }
}

include 'views/header.php';
include 'views/mycard.php';
include 'views/footer.php';

