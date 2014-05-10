<?php
if(!defined('IN_MOUGE'))
  die("Access Denied");
include 'views/cards_option.php'; ?>
<div class="row">
  <h1>哎呀，真尷尬</h1>
  <div class="small-12 panel column">
    <h3><?=$data['error']?></h3>
    <form action="search.php" method="get">
      <div class="row">
        <div class="large-6 column">
          <div class="row collapse">
            <div class="small-7 column">
              <select name="card">
                <?php showCardList(0); ?>
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
              <input type="text" name="keyword" placeholder="依卡片名稱搜尋">
            </div>
            <div class="small-5 column">
              <button class="postfix" type="submit" value="1">找戰友！</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

