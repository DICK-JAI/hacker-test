<?php  $logTitle=$article->Title;  ?>
<?php  $logIntro=SubstrUTF8(TransferHTML($article->Intro,'[nohtml]'),120) . '...';  ?>
<?php if ($logIntro==='...') { ?><?php  $logIntro='';  ?><?php } ?>
<?php if ($type==='search') { ?>
<?php  $logTitle=preg_replace('/' . preg_quote(GetVars('q'),'/') . '/i',"<mark>$0</mark>",$logTitle);  ?>
<?php  $logIntro=preg_replace('/' . preg_quote(GetVars('q'),'/') . '/i',"<mark>$0</mark>",$logIntro);  ?>
<?php } ?>
<article class="log<?php if ($article->IsTop) { ?> pin<?php } ?><?php if ($article->Cover) { ?> poster<?php } ?>">
  <?php if ($article->Cover) { ?>
  <figure><a href="<?php  echo $article->Url;  ?>"><img src="<?php  echo $article->Cover;  ?>" alt="<?php  echo $article->Title;  ?>" class="cover<?php if ($article->Cover===$host . 'zb_users/theme/Zit/style/bg.jpg') { ?> hue<?php } ?>"></a></figure>
  <?php } ?>
  <section class="pane">
    <h4 class="zit"><?php if ($article->IsTop) { ?><b><?php  echo $msg->sticky;  ?></b> <?php } ?><a href="<?php  echo $article->Category->Url;  ?>" title="<?php  echo $article->Category->Name;  ?>"><?php  echo $article->Category->Name;  ?></a></h4>
    <h3><a href="<?php  echo $article->Url;  ?>" title="<?php  echo $article->Title;  ?>"><?php  echo $logTitle;  ?></a></h3>
    <h5><?php  include $this->GetTemplate('kit-loginfo');  ?></h5>
    <div<?php if ($cfg->HideIntro) { ?> class="hidem"<?php } ?>><?php  echo $logIntro;  ?></div>
    <?php if ($cfg->ListTags&&$article->TagsName) { ?><div class="tags"><span class="tag"><?php  echo str_replace(',','</span> <span class="tag">',$article->TagsName);  ?></span></div><?php } ?>
  </section>
</article>