<?php
if(!defined('IN_MOUGE'))
  die('Access Denied');
?>
<div class="row">
  <div class="small-12 column">
    <h2><?=$data['topic']['title']?></h2>
  </div>
  <div class="small-12 column panel">
    <div class="small-12 column info">
      <span>作者：<?=$data['topic']['author_name']?> ，發佈時間：<?=$data['topic']['time']?></span>
    </div>
    <div class="small-12 column">
      <?=$data['topic']['content']?>
    </div>
  </div>
</div>

