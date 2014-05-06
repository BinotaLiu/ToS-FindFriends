<?php
if(!defined('IN_MOUGE'))
  die('Access Denied');
?>

<div class="row">
    <div class="small-12 panel column" id="topic">
      <h3>網站公告<h3>
      <ul style="list-style=none;">
      <?php foreach($data['topic'] as $topic): ?>
        <li><a href="topic.php?tid=<?=$topic['tid']?>"><?=$topic['title']?></a><i><?=date("Y-m-d G:s", $topic['time'])?></i>
      <?php endforeach; ?>
      </ul>
    </div>
</div>

