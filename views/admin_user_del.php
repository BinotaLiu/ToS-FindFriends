<?php
if(!defined('IN_MOUGE'))
  die('Access Denied');
if(empty($data['deleted'])):
?>
<div class="row">
  <div class="small-12 column">
    <h2>正在刪除：<?=$data['user']['uid']?>，<?=$data['user']['nickname']?></h2>
  </div>
  <div class="clear"></div>
  <div class="small-12 medium-6 medium-offset-3 column">
    <div class="small-12 medium-5 column">
      <form class="small-12" action="admin.php?mod=user&act=del&uid=<?=$_GET['uid']?>" method="POST">
        <input type="hidden" name="confirm" value="true">
        <button class="large small-12 radius alert column">確認刪除</button>
      </form>
    </div>
    <a class="button large small-12 medium-5 medium-offset-1 radius success column" href="admin.php?mod=user&act=view">返回列表</a>
  </div>
</div>
<?php else: ?>
<div class="row">
  <div data-alert class="alert-box successi radius">
    <h4>已刪除</h4>
    <a href="#" class="close">&times;</a>
  </div>
</div>
<?php endif;?>
