<?php
if(!defined('IN_MOUGE'))
  die("Access Denied");
?>
<div class="large-12 panel column" id="myDelegate">
  <h3>我的代表</h3>
  <p>您好，<?=$data['userName']?>，下列為您目前的代表資訊：</p>
    <div class="row">
      <div class="small-3 medium-2 large-2 column">
        <img style="width=100%;height=auto;" src="res/cards/<?=(file_exists("res/cards/{$data['card']['card_id']}.png")) ? $data['card']['card_id'] : "0"?>.png">
      </div>
      <div class="small-9 medium-10 large-8 column">
        <h3>目前代表：<?=$data['card']['name']?></h3>
        <h4>
          <ul class="inline-list">
            <li>卡片等級：<?=$data['card']['card_level']?></li>
            <li>技能等級：<?=$data['card']['skill_level']?></li>
          </ul>
        </h4>
        <h6 class="panel">
          <?=$data['card']['detail']?>
        </h6>
      </div>
      <div class="large-2 show-for-large-only column">
        <div class="large-12">
          <h4>候補代表：</h4>
        </div>
        <div class="large-12">
          <ul class="large-block-grid-2">
            <li><img style="width=100%;height=auto;" src="res/cards/<?=(file_exists("res/cards/{$data['card']['card1_id']}.png")) ? $data['card']['card1_id'] : "0"?>.png"></li>
            <li><img style="width=100%;height=auto;" src="res/cards/<?=(file_exists("res/cards/{$data['card']['card2_id']}.png")) ? $data['card']['card2_id'] : "0"?>.png"></li>
          </ul>
        </div>
        <div class="larg-12">
          <ul class="large-block-grid-2">
            <li><img style="width=100%;height=auto;" src="res/cards/<?=(file_exists("res/cards/{$data['card']['card3_id']}.png")) ? $data['card']['card3_id'] : "0"?>.png"></li>
            <li><img style="width=100%;height=auto;" src="res/cards/<?=(file_exists("res/cards/{$data['card']['card4_id']}.png")) ? $data['card']['card4_id'] : "0"?>.png"></li>
          </ul>
        </div>
      </div>
    <div class="small-12 medium-11 column">
        <a class="button radius large right" href="<?=$config['system']['basicurl']?>mycard/">編輯我的代表</a>
    </div>
  </div>
</div>
</div>
