<div class="row">
  <div class="small-12 column">
    <h1>搜尋：<?=$data['cardName']?></h1>
  </div>
<?php foreach($data['dbResult'] as $count => $value): ?>
    <div class="large-12 panel column">
      <h3><?=$data['usersName'][$count]?>，ID：<?php
  if($loginStatus)
    echo $value['tos_id'];
  else
    echo substr($value['tos_id'],0,3) . "********" . substr($value['tos_id'],-3,3) . "（登入以檢視完整 ID ）";
?></h3>
      <div class="clear"></div>
      <div class="row ">
        <div class="small-3 medium-2 column">
          <img style="width=100%;height=auto;" src="cards/<?=$value['card_id']?>.png">
        </div>
        <div class="small-9 column">
          <h3>目前代表：<?=$data['cardName']?></h3>
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
  </div>
<?php endforeach; ?>

</div>
