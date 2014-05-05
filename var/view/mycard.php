<?php include 'var/view/cards_option.php';?>
<div class="row">
  <?php if($data['success']): ?>
  <div data-alert class="alert-box success radius">
    <h4>資料更新成功！</h4>
    <a href="#" class="close">&times;</a>
  </div>
  <?php endif; ?>
  <?php if($data['expire']): ?>
  <div data-alert class="alert-box warning radius medium-6 medium-offset-3">
    <h5>您的資料已經 60 天沒有更新了！<br>
        系統已自動凍結您的資料，<br>
        並且不會在搜尋結果中顯示出來。<br>
        若要恢復，您只需要更新資料即可。</h5>
    <a href="#" class="close">&times;</a>
  </div>
  <?php endif; ?>
  <?php if($data['error']): ?>
  <div data-alert class="alert-box alert radius">
    <h4><?=$data['error']?></h4>
    <a href="#" class="close">&times;</a>
  </div>
  <?php endif; ?>

  <div class="small-12 column">
    <h1>我的卡片</h1>
  </div>
  <form action="mycard.php" method="post">
  <div class="small-12 panel column">
    <h3>我的資料</h3>
      <div class="row">
        <div class="small-12 column">
          <div class="row">
            <div class="small-3 column">
              <label for="tos_id" class="right inline">玩家 UID</label>
            </div>
            <div class="small-9 column">
              <input id="tos_id" name="tos_id" type="number" value="<?=$data['form']['tos_id']?>" placeholder="請輸入神魔之塔玩家 UID">
            </div>
          </div>
        </div>
        <div class="small-12 column">
          <div class="row">
            <div class="small-3 column">
              <label for="detail" class="right inline">留言</label>
            </div>
            <div class="small-9 column">
              <textarea id="detail" name="detail" placeholder="可以在這裡填入留言"><?=$data['form']['detail']?></textarea>
            </div>
          </div>
        </div>
      </div>
  </div>

  <div class="small-12 panel column">
    <h3>目前的代表：</h3>
      <div class="row">
        <div class="small-12 column">
          <div class="row">
            <div class="small-3 column">
              <label for="card_id" class="right inline">卡片</label>
            </div>
            <div class="small-9 column">
              <select id="card_id" name="card_id">
                <option value="0">-- 選擇卡片 --</option>
                <?php showCardList($data['form']['card_id']); ?>
              </select>
            </div>
          </div>
        </div>
        <div class="small-12 column">
          <div class="row">
            <div class="small-3 column">
              <label for="card_level" class="right inline">卡片等級</label>
            </div>
            <div class="small-9 column">
              <input type="number" id="card_level" name="card_level" value="<?=$data['form']['card_level']?>" placeholder="請輸入卡片等級" min="1" max="99">
            </div>
          </div>
        </div>
        <div class="small-12 column">
          <div class="row">
            <div class="small-3 column">
              <label for="skill_level" class="right inline">技能等級</label>
            </div>
            <div class="small-9 column">
              <input type="number" id="skill_level" name="skill_level" value="<?=$data['form']['skill_level']?>" placeholder="請輸入技能等級" min="-1" max="15">
            </div>
          </div>
        </div>
      </div>
  </div>

  <div class="small-12 panel column">
    <h3>候補代表</h3>
    <div class="row">
      <?php for($i=1;$i<5;$i++): ?>
      <div class="small-12 column">
        <div class="row">
          <div class="small-3 column">
            <label for="card<?=$i?>_id" class="right inline">候補 <?=$i?></label>
          </div>
          <div class="small-9 column">
            <select id="card<?=$i?>_id" name="card<?=$i?>_id">
              <option value="0">-- 選擇卡片 --</option>
              <?php showCardList($data['form']['card' . $i . '_id']); ?>
            </select>
          </div>
        </div>
      </div>
      <?php endfor; ?>
    </div>
  </div>
  <div class="small-4 small-offset-7 medium-3 medium-offset-8 large-2 large-offset-10">
    <button class="small-12 large radius" type="submit">保存</button>
  </div>
  </form>
</div>

