<?php  $userName=$article->Author->Name;  ?>
<?php if ($cfg->StaticName) { ?><?php  $userName=$article->Author->StaticName;  ?><?php } ?>
<div id="topic">
  <nav id="path" class="kico-dao kico-gap"><a href="<?php  echo $host;  ?>"><?php  echo $msg->home;  ?></a> | <a href="<?php  echo $article->Category->Url;  ?>"><?php  echo $article->Category->Name;  ?></a> | <a href="<?php  echo $article->TimeUrl;  ?>"><?php  echo $article->Time('Y-m-d');  ?></a></nav>
  <h4>
    <?php  foreach ( $article->Tags as $tag) { ?>
    <a href="<?php  echo $tag->Url;  ?>" class="tag"><?php  echo $tag->Name;  ?></a> 
    <?php }   ?>
  </h4>
  <h1><?php  echo $article->Title;  ?></h1>
  <h5><img src="<?php  echo $article->Author->Avatar;  ?>" class="avatar" alt="<?php  echo $userName;  ?>"> <a href="<?php  echo $article->Author->Url;  ?>" title="<?php  echo $msg->view;  ?> <?php  echo $userName;  ?><?php  echo $msg->logs;  ?>"><?php  echo $userName;  ?></a> <span class="kico-time"><dfn><?php  echo $msg->post;  ?></dfn><?php  echo $article->Time('Y-m-d H:i:s');  ?></span> <span class="kico-eye"><dfn><?php  echo $msg->views;  ?></dfn><?php  echo $article->ViewNums;  ?></span> <span  class="kico-ping"><dfn><?php  echo $msg->comments;  ?></dfn><?php  echo $article->CommNums;  ?></span></h5>
  <p><a href="#cmts" class="more"><span class="zit"><?php if ($article->CommNums) { ?><?php  echo $article->CommNums;  ?><?php  echo $msg->partake;  ?><?php }else{  ?><?php  echo $msg->sofa;  ?><?php } ?></span><?php  echo $msg->comment;  ?></a></p>
</div>
<?php  $blank='data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';  ?>
<main id="main">
  <article id="cont"><?php  echo $article->Content;  ?></article>
  <div id="rel">
    <h3 class="zit kico-zi"><?php  echo $cfg->RelatedTitle;  ?></h3>
    <ul>
    <?php if ($article->Prev) { ?>
    <li class="log">
      <a href="<?php  echo $article->Prev->Url;  ?>" title="<?php  echo $msg->view;  ?><?php  echo $article->Prev->Title;  ?>》<?php  echo $msg->details;  ?>">
        <img src="<?php if ($article->Prev->Cover) { ?><?php  echo $article->Prev->Cover;  ?><?php }else{  ?><?php  echo $blank;  ?><?php } ?>" alt="<?php  echo $article->Prev->Title;  ?>" class="cover">
        <span class="pane">
          <em class="zit kico-prev"><?php  echo $msg->prev;  ?></em>
          <b><?php  echo $article->Prev->Title;  ?></b>
          <span><small class="kico-time"><dfn><?php  echo $msg->post;  ?></dfn><?php  echo $article->Prev->Time('Y-m-d');  ?></small> <small class="kico-eye"><dfn><?php  echo $msg->views;  ?></dfn><?php  echo $article->Prev->ViewNums;  ?></small> <small class="kico-ping"><dfn><?php  echo $msg->comments;  ?></dfn><?php  echo $article->Prev->CommNums;  ?></small></span>
        </span>
      </a>
    </li>
    <?php } ?>
    <?php if ($article->Next) { ?>
    <li class="log">
      <a href="<?php  echo $article->Next->Url;  ?>" title="<?php  echo $msg->view;  ?>《<?php  echo $article->Next->Title;  ?>》<?php  echo $msg->details;  ?>">
        <img src="<?php if ($article->Next->Cover) { ?><?php  echo $article->Next->Cover;  ?><?php }else{  ?><?php  echo $blank;  ?><?php } ?>" alt="<?php  echo $article->Next->Title;  ?>" class="cover">
        <span class="pane">
          <em class="zit kico-next"><?php  echo $msg->next;  ?></em>
          <b><?php  echo $article->Next->Title;  ?></b>
          <span><small class="kico-time"><dfn><?php  echo $msg->post;  ?></dfn><?php  echo $article->Next->Time('Y-m-d');  ?></small> <small class="kico-eye"><dfn><?php  echo $msg->views;  ?></dfn><?php  echo $article->Next->ViewNums;  ?></small> <small class="kico-ping"><dfn><?php  echo $msg->comments;  ?></dfn><?php  echo $article->Next->CommNums;  ?></small></span>
        </span>
      </a>
    </li>
    <?php } ?>
    <?php  foreach ( $article->RelatedList as $related) { ?>
      <li class="log">
        <a href="<?php  echo $related->Url;  ?>" title="<?php  echo $msg->view;  ?>《<?php  echo $related->Title;  ?>》<?php  echo $msg->details;  ?>">
          <img src="<?php if ($related->Cover) { ?><?php  echo $related->Cover;  ?><?php }else{  ?><?php  echo $blank;  ?><?php } ?>" alt="<?php  echo $related->Title;  ?>" class="cover">
          <span class="pane">
            <time class="zit"><?php  echo $related->Time('Y-m-d');  ?></time>
            <b><?php  echo $related->Title;  ?></b>
            <span><small class="kico-eye"><dfn><?php  echo $msg->views;  ?></dfn><?php  echo $related->ViewNums;  ?></small> <small class="kico-ping"><dfn><?php  echo $msg->comments;  ?></dfn><?php  echo $related->CommNums;  ?></small>
            <?php  $tagi=0;  ?>
            <?php  foreach ( $related->Tags as $tag) { ?>
              <?php if($tagi++>2) break; ?>
              <small class="kico-hash"><?php  echo $tag->Name;  ?></small>
            <?php }   ?>
            <?php  $tagi=null;  ?>
            </span>
          </span>
        </a>
      </li>
    <?php }   ?>
    </ul>
  </div>
  <?php  include $this->GetTemplate('comments');  ?>
</main>
<aside id="side">
<?php  include $this->GetTemplate('sidebar3');  ?>
<?php  include $this->GetTemplate('kit-mside');  ?>
</aside>