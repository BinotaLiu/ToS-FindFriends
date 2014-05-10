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
    <h2>正在編輯：<?=$data['topic']['title']?></h2>
  </div>
  <form action="admin.php?mod=topic&act=edit&tid=<?=$data['topic']['tid']?>" method="post">
    <label>標題：
      <input type="text" name="title" value="<?=$data['topic']['title']?>">
    </label>
    <label>作者：
      <input type="text" name="author" value="<?=$data['topic']['author']?>">
    </label>
    <label>發表時間：
      <input type="text" name="time" value="<?=$data['topic']['time']?>">
    </label>
    <label>內文：
      <textarea name="content"><?=$data['topic']['content']?></textarea>
    </label>
    <button class="large radius" type="submit">保存</button>
    <a class="button large radius success" href="admin.php?mod=topic&act=view">回到列表</a>
  </form>
</div>
