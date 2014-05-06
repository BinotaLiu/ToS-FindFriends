<?php
if(!defined('IN_MOUGE'))
  die('Access Denied');
?>
<div class="row">
  <div class="small-12 column">
    <h2><?=$data['topic']['title']?></h2>
  </div>
  <div class="small-12 column panel">
    <div class="small-12 column info">
      <span>作者：<?=$data['topic']['author_name']?> ，發佈時間：<?=$data['topic']['time']?></span>
    </div>
    <div class="small-12 column">
      <?=$data['topic']['content']?>
    </div>
  </div>
    <div id="disqus_thread" class="small-10 small-offset-1 medium-12 medium-offset-0 column"></div>
    <script type="text/javascript">
        var disqus_shortname = '<?=$config['social']['disqus']['shortname']?>';

        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
    </script>
    <noscript>請啟用 JavaScript 以檢視來自<a href="http://disqus.com/?ref_noscript">Disqus</a>的留言</noscript>
    <a href="http://disqus.com" class="dsq-brlink">留言功能自豪地採用 <span class="logo-disqus">Disqus</span></a>
</div>

