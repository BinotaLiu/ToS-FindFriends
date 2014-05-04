<!doctype html>
<html lang="zh-TW">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$data['title']?></title>
    <link rel="stylesheet" href="css/foundation.css"> 
    <script src="js/vendor/modernizr.js"></script>
    <style type="text/css">
      body {
        background: #EEE;
      }
    </style>
  </head>
  <body>

    <nav class="top-bar" data-topbar>
      <ul class="title-area">
        <li class="name">
          <h1><a href="#"><?=$data['nav_title']?></a></h1>
        </li>
        <li class="toggle-topbar menu-icon"><a href="#"><span>您好，<?php if($loginStatus){ echo $data['userName']; }else{?>遊客<?php } ?>！</span></a></li>
      </ul>
      <section class="top-bar-section">
        <ul class="right">
<?php if($loginStatus == 1): ?>
          <li class="show-for-medium-up"><a href="home.php">您好，<?=$data['userName']?>！</a></li>
          <li><a href="setting.php">個人設定</a></li>
          <li><a href="mycard.php">編輯代表資訊</a></li>
          <li><a href="logout">登出</a></li>
<?php else: ?>
          <li><a href="login.php?method=facebook">Facebook 登入</a></li>
          <li><a href="login.php?method=persona">Persona 登入</a></li>
<?php endif; ?>
        </ul>
      </section>
    </nav>
