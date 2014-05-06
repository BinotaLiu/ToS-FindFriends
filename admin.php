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

  switch($mod){
    case 'topic':
      switch($act){
        case 'add':
          if(!empty($_POST['title'])){
            $db->insert('official_topic', array(
                                            'title' => $_POST['title'],
                                           'author' => $data['uid'],
                                             'time' => time(),
                                          'content' => $_POST['content']));
            $data['success'] = TRUE;
          }
            include 'views/admin_topic_add.php';
          break;
        case 'edit':
          //如果收到了就……
          if(!empty($_POST['title'])){
            $db->update('official_topic', array('*'), array(
                                                      'title' => $_POST['title'],
                                                     'author' => $_POST['author'],
                                                       'time' => $_POST['time'],
                                                    'content' => $_POST['content']), array(
                                                        'tid' => $_GET['tid']));
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
    case 'home':
    default:
      include 'views/admin_home.php';
  }//switch($mod)

}

include 'views/footer.php';

