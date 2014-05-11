<div class="row">
  <div class="small-12 column">
    <h2>選擇卡片</h2>
    <div class="small-12 column panel">
      <h3>搜尋</h3>
      <form action="card_picker.php" method="get">
        <input type="hidden" name="id" value="<?!empty($_GET['id'])?$_GET['id']:""?>">
        <div class="row">
          <div class="small-7 column">
            <input type="text" name="keyword" placeholder="依卡片名稱搜尋">
          </div>
          <div class="small-5 column">
            <button type="submit" class="postfix">找卡片</button>
          </div>
        </div>
      </form>
    </div>
    <div class="small-12 column panel text-center">
<?php if(!empty($_GET['keyword'])):
        foreach($result as $card):
?>
      <div class="small-6 medium-3 column">
        <img src="<?=$config['system']['basicurl']?>res/cards/<?=
(file_exists('res/cards/' . $card['card_id'] . '.png')) ? $card['card_id'] : 0 ?>.png"><br><br>
<a href="#" onclick="setParent('<?=!empty($_GET['id'])?$_GET['id']:""?>', '<?=$card['card_id']?>')" class="small-12 column button success medium radius"><?=$cardInfo[$card['card_id']]['cardName']?></a>
      </div>
<?php   endforeach;
      else:
$nowOnId = (!empty($_GET['start']) && intval($_GET['start']) > 0 && intval($_GET['start'] < 564)) ? $_GET['start'] : 1;
$cardCount = count($cardInfo);
for($i = 0; $i < 20 && $nowOnId <= $cardCount; $i++, $nowOnId++ ):?>
      <div class="small-6 medium-3 column">
        <img src="<?=$config['system']['basicurl']?>res/cards/<?=
(file_exists('res/cards/' . $nowOnId . '.png')) ? $nowOnId : 0 ?>.png"><br><br>
<a href="#" onclick="setParent('<?=!empty($_GET['id'])?$_GET['id']:""?>', '<?=$nowOnId?>')" class="small-12 column button success medium radius"><?=$cardInfo[$nowOnId]['cardName']?></a>
      </div>
<?php endfor; ?>
    </div>
  <div class="right">
<?php if(!empty($_GET['start']) && intval($_GET['start'] > 20)): ?>
    <a href="<?=$config['system']['basicurl']?>card_picker.php?id=<?=!empty($_GET['id'])?$_GET['id']:"0"?>&start=<?=$_GET['start']-20?>" class="button radius" style="text-overflow:ellipsis">上一頁</a>
<?php endif; if(!empty($cardInfo[$nowOnId + 1])): ?>
    <a href="<?=$config['system']['basicurl']?>card_picker.php?id=<?=!empty($_GET['id'])?$_GET['id']:"0"?>&start=<?=$nowOnId+1?>" class="button radius" style="text-overflow:ellipsis">下一頁</a>
<?php endif; endif;?>
  </div>
</div>

