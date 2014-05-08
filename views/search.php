<?php
if(!defined('IN_MOUGE'))
  die("Access Denied");
?>
<div class="row">
  <div class="small-12 column">
    <h1>搜尋：<?=empty($data['searchName'])?"":$data['searchName']?></h1>
  </div>
<?php if(!empty($data['dbResult'])){
      foreach($data['dbResult'] as $count => $value): ?>
  <div class="large-12 panel column">
    <h3>
<?php
      echo $data['usersName'][$count];
      echo "，ID：";
      if($loginStatus)
        echo $value['tos_id'];
      else
        echo substr($value['tos_id'],0,3) . "******" . substr($value['tos_id'],-1,1) . "（登入以檢視完整 ID ）";
?>
    </h3>
    <div class="clear"></div>
    <div class="row">
      <div class="small-3 medium-2 large-2 column">
        <img style="width=100%;height=auto;" src="<?=$config['system']['basicurl']?>res/cards/<?=(file_exists("res/cards/{$value['card_id']}.png")) ? $value['card_id'] : "0"?>.png">
      </div>
      <div class="small-9 medium-10 large-8 column">
        <h3>目前代表：<?=$data['cardName'][$count]?></h3>
        <h4>
          <ul class="inline-list">
            <li>卡片等級：<?=$value['card_level']?></li>
            <li>技能等級：<?=$value['skill_level']?></li>
          </ul>
        </h4>
        <h6 class="panel">
          <?=$value['detail']?>
        </h6>
      </div>
      <div class="large-2 show-for-large-only column">
        <div class="large-12">
          <h4>候補代表：</h4>
        </div>
        <div class="large-12">
          <ul class="large-block-grid-2">
            <li><img style="width=100%;height=auto;" src="<?=$config['system']['basicurl']?>res/cards/<?=(file_exists("res/cards/{$data['second'][$count]['card1_id']}.png")) ? $data['second'][$count]['card1_id'] : "0"?>.png"></li>
            <li><img style="width=100%;height=auto;" src="<?=$config['system']['basicurl']?>res/cards/<?=(file_exists("res/cards/{$data['second'][$count]['card2_id']}.png")) ? $data['second'][$count]['card2_id'] : "0"?>.png"></li>
          </ul>
        </div>
        <div class="larg-12">
          <ul class="large-block-grid-2">
            <li><img style="width=100%;height=auto;" src="<?=$config['system']['basicurl']?>res/cards/<?=(file_exists("res/cards/{$data['second'][$count]['card3_id']}.png")) ? $data['second'][$count]['card3_id'] : "0"?>.png"></li>
            <li><img style="width=100%;height=auto;" src="<?=$config['system']['basicurl']?>res/cards/<?=(file_exists("res/cards/{$data['second'][$count]['card4_id']}.png")) ? $data['second'][$count]['card4_id'] : "0"?>.png"></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
<?php endforeach;?>
  <div class="small-12 column">
    <div class="small-12 medium-7 medium-offset-5 panel column">
      <ul class="pagination">
        <?php if($page>0) : ?>
        <li>
          <a href="<?=$config['system']['basicurl']?>search/<?php echo !empty($card) ? 'card/' . $card : ''; echo !empty($keyword) ? 'keyword/' . urlencode($keyword) : '';?>/<?=($page-10 > 0) ? '1' : $page-10?>/">
        <?php else: ?>
        <li class="arrow unavailable">
          <a href="#">
        <?php endif; ?>
          &laquo;
          </a>
        </li>
        <li class="current"><a href="<?=$config['system']['basicurl']?>search/<?php echo !empty($card) ? 'card/' . $card : ''; echo !empty($keyword) ? 'keyword/' . htmlentities($keyword) : '';?>/<?=$page+1?>/"><?=$page+1?></a></li>
<?php for($i = 2, $pPage = $page + 2;
          $i <= 10 && $pPage <= $data['totalPage'];
          $i++, $pPage++):
      /*[Note]: 停止條件：
                  1. 輸出了 10 頁以上。
                  2. 輸出的頁數超過了總頁數。*/?>
        <li><a href="<?=$config['system']['basicurl']?>search/<?php echo !empty($card) ? 'card/' . $card : ''; echo !empty($keyword) ? 'keyword/' . urlencode($keyword) : '';?>/<?=$pPage?>/"><?=$pPage?></a></li>
<?php endfor; ?>
        <li>
<?php if($page+10<$data['totalPage']) { ?><a href="<?=$config['system']['basicurl']?>search/<?php echo !empty($card) ? 'card/' . $card : ''; echo !empty($keyword) ? 'keyword/' . urlencode($keyword) : '';?>/<?=$page+10?>/">
        ...
<?php }
      if($page+10<$data['totalPage']) { ?></a><?php } ?>
        </li>
        <li>
<?php if($page+1<$data['totalPage']) { ?><a href="<?=$config['system']['basicurl']?>search/<?php echo !empty($card) ? 'card/' . $card : ''; echo !empty($keyword) ? 'keyword/' . urlencode($keyword) : '';?>/<?=$page+2?>/"><? } ?>
      &raquo;
<?php if($page+1<$data['totalPage']){ ?></a><?php } ?>
        </li>
      </ul>
    </div>
  </div>
<?php
}else{
include 'views/cards_option.php'; ?>
  <div class="small-12 panel column">
    <h3>這裡什麼都沒有，要不要換個東西搜尋看看？</h3>
        <form action="search.php" method="get">
          <div class="row">
            <div class="large-6 column">
              <div class="row collapse">
                <div class="small-7 column">
                  <select name="card">
                    <?php showCardList(0); ?>
                  </select>
                </div>
                <div class="small-5 column">
                  <button class="postfix" type="submit" value="0">找戰友！</button>
                </div>
              </div>
            </div>
            <div class="large-6 column">
              <div class="row collapse">
                <div class="small-7 column">
                  <input type="text" name="keyword" placeholder="依卡片名稱搜尋">
                </div>
                <div class="small-5 column">
                  <button class="postfix" type="submit" value="1">找戰友！</button>
                </div>
              </div>
            </div>
          </div>
        </form>
  </div>
<?php } ?>
</div>
