<?php
if(!defined('IN_MOUGE'))
  die("Access Denied");


function showCardList($id)
{
  //先輸出傳入的$id
  //static $cardInfo;
  include 'cards.inc.php';
  if($id == 0){
    echo '<option value="0">---- 請選擇卡片 ----</option>';
  }else{
    echo '<option value="' . $id .'" selected="selected">No.' .
        $id . ' ' . $cardInfo[$id]['cardName'] . ' （' . $cardInfo[$id]['star'] . '星）</option>';
  }
  foreach($cardInfo as $id => $value){
    echo '<option value="' . $id .'">No.' .
     $id . ' ' . $value['cardName'] . ' （' . $value['star'] . '星）</option>';
  }
}
