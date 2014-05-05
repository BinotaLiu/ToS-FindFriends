<?php
if(!defined('IN_MOUGE'))
  die("Access Denied");
?>
      <div class="large-12 panel column">
        <h3>我的代表</h3>
        <p>您好，<?=$data['userName']?>，下列為您目前的代表資訊：</a>
        <div class="clear"></div>
        <div class="row">
          <div class="small-3 medium-2 column">
            <a href="mycard.php"><img style="width=100%;height=auto;" src="cards/<?=$data['card']['card_id']?>.png"></a>
          </div>
          <div class="small-9 medium-10 column">
            <h3>目前代表：<?=$data['card']['name']?></h3>
            <h4>
              <ul class="inline-list">
                <li>卡片等級：<?=$data['card']['card_level']?></li>
                <li>技能等級：<?=$data['card']['skill_level']?></li>
              </ul>
            </h4>
            <h6 class="panel small-12">
              <?=$data['card']['detail']?>
            </h6>
          </div>
          <div class="clear"></div>
          <div class="small-12 medium-5 medium-offset-6 column">
              <a class="button radius large small-12" href="mycard.php">編輯/檢視詳細資訊</a>
          </div>
        </div>
      </div>
    </div>
