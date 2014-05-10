<?php
if(!defined('IN_MOUGE'))
  die('Access Denied');

if(!empty($data['success'])):?>
<div class="row">
  <div class="small-12 medium-8 medium-offset-2 column">
    <div data-alert class="alert-box success radius">
      <h4>已保存</h4>
      <a href="#" class="close">&times;</a>
    </div>
  </div>
</div>
<?php
endif;
?>
<div class="row">
  <div class="small-12">
    <h2>正在新增公告</h2>
  </div>
  <form action="admin.php?mod=topic&act=add" method="post">
    <label>標題：
      <input type="text" name="title">
    </label>
    <label>內文：
      <textarea name="content" rows="15"></textarea>
    </label>
    <button class="large radius" type="submit">保存</button>
    <a class="button large radius success" href="admin.php?mod=topic&act=view">回到列表</a>
  </form>
</div>
