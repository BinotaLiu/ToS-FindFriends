<?php
/*
 * Filename: admin.php
 * $Id$
 * 管理中心。
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
$data['nav_title'] = "管理中心";
if($loginStatus){
  $data['uid'] = $_SESSION['user_id'];
  $data['userName'] = $_SESSION['user_name'];
}

if($_SESSION['user_level'] != 1){
  include 'views/header.php';
  $data['url'] = $config['system']['basicurl'];
  $data['notice'] = "抱歉，您無權瀏覽此頁面";
  include 'views/redirect.php';
}else{
  include 'views/admin_header.php';

  $mod = empty($_GET['mod']) ? "home" : $_GET['mod'];
  $act = empty($_GET['act']) ? "default" : $_GET['act'];

  $page = empty($_GET['page']) ? 1 : $_GET['page'];

  switch($mod){
    case 'topic':
      switch($act){
        case 'del':
          if(!empty($_POST['confirm'])){
            $db->delete('official_topic', array('tid' => $_GET['tid']))[0];
            $data['deleted'] = true;
          }else{
            $data['topic'] = $db->fetch_where('official_topic', array('*'), array('tid' => $_GET['tid']))[0];
            $data['topic']['author_name'] = $db->fetch_where(
                                                   'user',
                                                   array('nickname'),
                                                   array('uid' => $data['topic']['author']))[0]['nickname'];
          }
          include 'views/admin_topic_del.php';
          break;
        case 'add':
          if(!empty($_POST['title'])){
            $db->query('INSERT INTO official_topic (`title`, `author`, `time`, `content`) VALUES (' .
                       '"' . $db->fix_string($_POST['title']) . '",' .
                       '"' . $data['uid'] . '",' . 
                       '"' . time() . '",' .
                       '"' .  $_POST['content'] . '")');
            $data['success'] = TRUE;
          }
          include 'views/admin_topic_add.php';
          break;
        case 'edit':
          //如果收到了就……
          if(!empty($_POST['title'])){
            $db->query('UPDATE official_topic SET `title`="' . $_POST['title'] . '", `author`="' . $_POST['author'] . '", `time`="' . $_POST['time'] . '", `content`="' . $_POST['content'] . '" WHERE `tid`="' . $_GET['tid'] . '"');
            $data['success'] = TRUE;
          }
          $data['topic'] = $db->fetch_where('official_topic', array('*'), array('tid' => $_GET['tid']))[0];
          include 'views/admin_topic_edit.php';
          break;
        case 'view':
        default:
          $data['topic'] = $db->fetch('official_topic');
          include 'views/admin_topic_view.php';
      }
      break;
    case 'user':
      switch($act){
        case 'del':
          if(!empty($_POST['confirm'])){
            $db->delete('user', array('uid' => $_GET['uid']))[0];
            $data['deleted'] = true;
          }else{
            $data['user'] = $db->fetch_where('user', array('uid', 'nickname'), array('uid' => $_GET['uid']))[0];
          }
          include 'views/admin_user_del.php';
          break;
        case 'setadmin':
          $db->update('user', array('user_level' => $_GET['type']), array('uid' => $_GET['uid']));
          $data['success'] = $_GET['type'] ? "已將使用者設為管理員" : "已將使用者還原為普通使用者";
        case 'view':
        default:
          $data['user'] = $db->fetch('user', array('*'), ($page-1)*10, 10);
          include 'views/admin_user_view.php';
      }//switch($act)
      break;
    case 'home':
    default:
      include 'views/admin_home.php';
  }//switch($mod)

}

include 'views/footer.php';

