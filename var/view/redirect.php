<div class="row">
  <div class="small-12 column">
    <h1>正在重新導向……</h1>
  </div>
  <div class="clear"></div>
  <div class="small-12 panel column">
    <h3><?=$data['notice']?></h3>
    <h6><a href="<?=$data['url']?>">如果沒有自動重新導向，請輕觸這裡</a></h6>
  </div>
  <script><!--
    setTimeout('window.location = "<?=$data['url']?>"', 3000);
  --></script>
</div>
