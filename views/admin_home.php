<?php
if(!defined('IN_MOUGE'))
  die('Access Denied');
?>

<div class="row">
  <div class="small-12 column">
    <h2>管理中心</h2>
  </div>
  <div class="small-12 panel column">
    <h3>早安，<?=$data['userName']?></h3>
    <ul class="inline-list">
      <li><a class="button large radius" href="admin.php?mod=topic">管理公告</a></li>
      <li><a class="button large radius" href="admin.php?mod=user">管理使用者</a></li>
      <li><a class="button large radius" href="admin.php?mod=feedback">檢視意見回饋</a></li>
      <li><a class="button large radius" href="index.php">回到網站</a></li>
      <li><a class="button large radius success" href="login.php?logout=true">登出</a></li>
    </ul>
  </div>
</div>
