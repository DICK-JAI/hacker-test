<div id="topic">
  <nav id="path" class="kico-dao kico-gap"><a href="<?php  echo $host;  ?>"><?php  echo $msg->home;  ?></a> | <a><?php  echo $title;  ?></a></nav>
  <h1><?php  echo $article->Title;  ?></h1>
  <?php if (!$article->IsLock) { ?><p><a href="#cmts" class="more"><span class="zit"><?php if ($article->CommNums) { ?><?php  echo $article->CommNums;  ?><?php  echo $msg->partake;  ?><?php }else{  ?><?php  echo $msg->sofa;  ?><?php } ?></span><?php if ($cfg->GbookID==$article->ID) { ?><?php  echo $msg->message;  ?><?php }else{  ?><?php  echo $msg->comment;  ?><?php } ?></a></p><?php } ?>
</div>
<main id="main">
  <article id="cont"><?php  echo $article->Content;  ?></article>
<?php  include $this->GetTemplate('comments');  ?>
</main>
<aside id="side">
<?php if ($cfg->GbookID==$article->ID) { ?>
  <?php  include $this->GetTemplate('sidebar5');  ?>
<?php }else{  ?>
  <?php  include $this->GetTemplate('sidebar4');  ?>
<?php } ?>
<?php  include $this->GetTemplate('kit-mside');  ?>
</aside>
