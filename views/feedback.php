<?php
if(!defined('IN_MOUGE'))
  die('Access Denied');

if(empty($data['success'])): ?>
<div class="row">
  <div class="small-12 column">
    <h2>意見回饋</h2>
  </div>
  <div class="small-12 column">
    <form action="feedback.php" method="post">
      <div class="small-12 panel column">
        <div class="row">
          <div class="small-12 medium-3 column">
            <label class="right inline" for="title">標題</label>
          </div>
          <div class="small-12 medium-9 column">
            <input id="title" type="text" name="title" placeholder="請輸入標題" required>
          </div>
        </div>
        <div class="row">
          <div class="small-12 medium-3 column">
            <label class="right inline" for="content">內容</label>
          </div>
          <div class="small-12 medium-9 column">
            <textarea id="content" rows="10" name="content" placeholder="請輸入內容" required></textarea>
          </div>
        </div>
      </div>
      <div class="small-12 column">
        <button class="right large success radius" type="submit">送出</button>
      </div>
    </form>
</div>
<?php else: ?>
<div class="row">
  <div class="small-12 medium-6 medium-offset-3 column">
    <div data-alert class="alert-box success radius small-12 column">
      <h4 class="text-center">您的回饋已送出！感謝！</h4>
      <a href="#" class="close">&times;</a>
    </div>
  </div>
</div>
<?php endif; ?>

