<?php
if(!defined('IN_MOUGE'))
  die("Access Denied");
?>

<div class="row">
  <div class="small-11 small-offset-1 medium-offset-0 column">
    <h5 style="color:#777;font-size:.7em;">
    2012-2014 &copy; Studio-MouGE, All Right Reserved.</h5>
    <h6 style="color:#777;font-size:.65em;">
    Online Version: <?=$config['system']['version']?><br>
    Page generated at <?=date("Y-m-d G:i:s", time())?><br>
    Page Seed: <?=(!empty($_COOKIE['__tos123_sessid'])) ? htmlentities($_COOKIE['__tos123_sessid']) : "First visit."?></h6>
  </div>
</div>

<script src="<?=$config['system']['basicurl']?>res/js/vendor/jquery.js"></script>
<script src="<?=$config['system']['basicurl']?>res/js/foundation.min.js"></script>
<script>
  $(document).foundation();

  $('#0_picker').click(function(){openPicker(0);});
  $('#1_picker').click(function(){openPicker(1);});
  $('#2_picker').click(function(){openPicker(2);});
  $('#3_picker').click(function(){openPicker(3);});
  $('#4_picker').click(function(){openPicker(4);});

  function openPicker(id){
    window.open('<?=$config['system']['basicurl']?>card_picker.php?id='+id, '請選擇卡片', "height=600, width=800, scrollbars=yes");
  };
  function setParent(fid, cid){
    $('#card'+fid+'_id', window.opener.document).val(cid);
    self.close();
  }
</script>
</body>
</html>
