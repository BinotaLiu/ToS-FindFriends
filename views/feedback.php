<?php
if(!defined('IN_MOUGE'))
  die('Access Denied');

if(empty($data['success'])): ?>
<div class="row">
  <div class="small-12 column">
    <h2>意見回饋</h2>
  </div>
  <form action="feedback.php" method="post">
    <label>標題
        <input type="text" name="title" placeholder="請輸入標題"></label>
    <label for="content">內容
        <textarea rows="10" name="content" placeholder="請輸入內容"></textarea></label>
    <button class="large success radius" type="submit">送出</button>
  </form>
</div>
<?php else: ?>
<div class="row">
  <div class="small-12 medium-6 medium-offset-3 column">
    <div data-alert class="alert-box success radius small-12 column">
      <h4>您的回饋已送出！感謝！</h4>
      <a href="#" class="close">&times;</a>
    </div>
  </div>
</div>
<?php endif; ?>

