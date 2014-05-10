<?php if(empty($_COOKIE['notutorial'])): ?>
<div class="alert-box secondery" data-alert>
  <div class="small-12 column panel">
  <div class="small-12 medium-4 column">
    <h3>第一步</h3>
    <?php if(!$loginStatus): ?>
    <a href="<?=$config['system']['basicurl']?>login.php?method=facebook" class="small-10 small-offset-1 column button success radius">Facebook 登入</a><br>
    <a href="javascript:navigator.id.request()" class="small-10 small-offset-1 column button success radius">E-Mail 登入</a>
    <?php else: ?>
    <p>第一步完成啦！趕快進行第二步吧！</p>
    <?php endif; ?>
  </div>
  <div class="small-12 medium-4 column">
    <h3>第二步</h3>
    <p><a href="<?=$config['system']['basicurl']?>mycard/" class="small-10 small-offset-1 column button success radius">登記自己的代表</a></p>
  </div>
  <div class="small-12 medium-4 column">
    <h3>第三步</h3>
    <p><a href="<?=$config['system']['basicurl']?>search.php" class="small-10 small-offset-1 column button success radius">找找自己需要的戰友</a></p>
    <p>（註：目前網站正在建設初期，需要大家多多登記自己的代表，否則大家都找不到對方哦<?=htmlentities("><")?>）</p>
  </div>
  <div class="small-4 text-right column">
    <a class="large button secondary" href="?notutorial=true">關閉</a>
  </div>
  </div>
</div>
<?php endif; ?>

