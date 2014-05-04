
<div class="row">
    <div class="small-12 column">
      <h1>設定</h1>
    </div>
    <div class="clear"></div>
    <div class="small-12 panel column">
      <h3>個人資料</h3>
      <div class="row">
        <form action="setting.php" method="post">
          <div class="small-12 column">
            <div class="row">
              <div class="small-3 column">
                <label class="right inline" for="loginmethod">登入方式</label>
              </div>
              <div class="small-9 column">
                <input type="text" id="loginmethod" disabled="disabled" value="<?=$data['form']['loginmethod']?>">
              </div>
            </div>
            <div class="row">
              <div class="small-3 column">
                <label class="right inline" for="nickname">昵稱</label>
              </div>
              <div class="small-9 column">
                <input type="text" id="nickname" name="nickname" value="<?=$data['form']['nickname']?>" placeholder="請輸入昵稱">
              </div>
            </div>
          </div>
          <button class="small-4 column medium" type="submit">保存</button>
        </form>
      </div>
    </div>

</div>

