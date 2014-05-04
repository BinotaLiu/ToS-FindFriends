<!doctype html>
<html lang="utf-8">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?=$data['title']?></title>
    <link rel="stylesheet" href="css/foundation.css" />
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
        <li class="toggle-topbar menu-icon"><a href="#"><span>功能表</span></a></li>
      </ul>
      <section class="top-bar-section">
        <ul class="right">
          <li class="has-dropdown">
<?php if($loginStatus == 1): ?>
            <a href="#"><?=$data['userName']?></a>
            <ul class="dropdown">
              <li><a href="#">設定</a></li>
              <li><a href="#">登出</a></li>
            </ul>
<?php else: ?>
            <a href="#">您好，遊客！</a>
            <ul class="dropdown">
              <li><a href="#">Facebook 登入</a></li>
              <li><a href="#">Persona 登入</a></li>
            </ul>
<?php endif; ?>
          </li>
        </ul>
      </section>
    </nav>
