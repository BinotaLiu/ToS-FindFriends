<?php
if(!defined('IN_MOUGE'))
  die('Access Denied');
if(!empty($data['success'])):
?>
<div class="row">
  <div class="small-12 medium-6 medium-offset-3 column">
    <div data-alert class="alert-box success large">
      <h4><?=$data['success']?></h4>
      <a href="#" class="close">&times;</a>
    </div>
  </div>
</div>
<?php endif; ?>
<div class="row">
  <div class="small-12 column">
    <h2>使用者管理</h2>
  </div>
  <div class="small-12 column">
    <h4>搜尋</h4>
    <form action="admin.php" method="get">
      <input type="hidden" name="mod" value="user">
      <input type="hidden" name="act" value="search">
      <select name="method">
        <option value="0">UID</option>
        <option value="1">昵稱</option>
      </select>
      <input type="text" name="keyword">
      <button type="submit">搜尋</button>
    </form>
  </div>
  <div class="small-12 column">
    <table class="small-12 column">
      <thead>
        <tr>
          <td>UID</td>
          <td>昵稱</td>
          <td>註冊時間</td>
          <td>最後登入</td>
          <td>帳號等級</td>
          <td>Actions</td>
        </tr>
      <thead>
      <tbody>
<?php foreach($data['user'] as $count => $user): ?>
        <tr>
          <td><?=$user['uid']?></td>
          <td><?=$user['nickname']?></td>
          <td><?=date("Y-m-d G:i:s", $user['regtime'])?></td>
          <td><?=date("Y-m-d G:i:s", $user['lastlogin'])?></td>
          <td><?=$user['user_level']?"管理員":"普通使用者"?></td>
          <td><ul class="inline-list">
                <li><a href="admin.php?mod=user&act=del&uid=<?=$user['uid']?>">刪除</a></li>
                <li><a href="admin.php?mod=user&act=setadmin&uid=<?=$user['uid']?>&type=<?=$user['user_level'] ? 0 : 1?>">設為管理員</a></li>
                <li><a href="admin.php?mod=card&act=detail&uid=<?=$user['uid']?>">編輯代表資訊</a></li></ul></td>
        </tr>
<?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <div class="clear"></div>
  <div class="small-12 medium-3 medium-offset-9 large-2 large-offset-9 column panel">
    <ul class="inline-list">
      <li><a href="admin.php?mod=user&act=view&page=<?=$page-1?>">上一頁</a></li>
      <li><a href="admin.php?mod=user&act=view&page=<?=$page+1?>">下一頁</a></li>
    </ul>
  </div>
</div>

