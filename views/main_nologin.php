<?php
if(!defined('IN_MOUGE'))
  die("Access Denied");
?>
      <div class="large-12 panel column">
        <h3>刊登自己的代表</h3>
        <p>請先登入，本站提供兩種方式進行登入，建議使用 Persona 帳號登入（以 E-Mail 進行登入）</p>
        <div class="clear"></div>
        <div class="small-12 column">
          <a class="small-12 medium-4 medium-offset-1 column button large radius" href="login.php?method=facebook">Facebook 登入</a>
          <a class="small-12 medium-4 medium-offset-2 end column button large radius" href="javascript:navigator.id.request()">Persona 登入</a>
        </div>
      </div>
    </div>
