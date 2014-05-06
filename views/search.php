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
      <div class="small-3 medium-2 column">
        <img style="width=100%;height=auto;" src="res/cards/<?=(file_exists("res/cards/{$value['card_id']}.png")) ? $value['card_id'] : "0"?>.png">
      </div>
      <div class="small-9 medium-10 column">
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
    </div>
  </div>
<?php endforeach;?>
  <div class="small-12 column">
    <div class="small-12 medium-5 medium-offset-7 panel column">
      <ul class="inline-list">
<?php for($i = 1, $pPage = $page + 1;
          $i <= 10 && $pPage + $i <= $data['totalCount'];
          $i++, $pPage++): ?>
        <li><a href="search.php?card=<?=$card?>&keyword=<?=$keyword?>&page=<?=$pPage?>"><?=$pPage?></a></li>
<?php endfor; ?>
        <li>...</li>
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
                    <option value="0">-- 選擇卡片 --</option>
                    <?php showCardList(null); ?>
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
                  <input type="text" name="keyword" placeholder="依卡片名稱搜尋"></input>
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
