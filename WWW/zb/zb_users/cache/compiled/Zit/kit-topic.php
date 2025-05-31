<article id="topic">
  <?php if ($type!=='index') { ?><nav id="path" class="kico-dao kico-gap"><a href="<?php  echo $host;  ?>"><?php  echo $msg->home;  ?></a> | <a><?php  echo $title;  ?></a></nav><?php } ?>
  <?php  $cmtids=json_decode(isset($modules['zit_cmtids'])?$modules['zit_cmtids']->Content:'',true);  ?>
  <?php if (trim($cfg->CmtIds,',')) { ?>
    <?php  $cmtids=explode(',',$cfg->CmtIds);  ?>
  <?php } ?>
<?php if ($cmtids) { ?>
  <?php  $cmtid=$cmtids[array_rand($cmtids,1)];  ?>
  <?php  $cmt=$zbp->GetCommentByID($cmtid);  ?>
  <?php if ($cmt->Post->Tags) { ?>
  <h4>
    <?php  foreach ( $cmt->Post->Tags as $tag) { ?>
    <a href="<?php  echo $tag->Url;  ?>" class="tag"><?php  echo $tag->Name;  ?></a> 
    <?php }   ?>
    <?php  $tag=null;  ?>
  </h4>
  <?php } ?>
  <h2 class="kico-ping"><a href="<?php  echo $cmt->Post->Url;  ?>" title="<?php  echo $msg->view;  ?>《<?php  echo $cmt->Post->Title;  ?>》<?php  echo $msg->details;  ?>"><?php  echo SubStrUTF8(TransferHTML($cmt->Content,'[nohtml]'),40);  ?>...</a></h2>
  <p <?php if ($cfg->HideIntro) { ?> class="hidem"<?php } ?>><?php  echo SubStrUTF8(TransferHTML($cmt->Post->Content,'[nohtml]'),140);  ?>...</p>
  <small><?php if ($cmt->Post->CommNums>1) { ?><?php  echo $msg->other;  ?> <?php  echo $cmt->Post->CommNums-1;  ?> <?php  echo $msg->commented;  ?><?php }else{  ?><?php  echo $msg->expect;  ?><?php } ?></small>
  <a href="<?php  echo $cmt->Post->Url;  ?>" title="<?php  echo $msg->view;  ?>《<?php  echo $cmt->Post->Title;  ?>》<?php  echo $msg->details;  ?>" rel="nofollow" class="more"><?php  echo $msg->join;  ?><span class="zit"><?php  echo $cmt->Post->ViewNums;  ?><?php  echo $msg->guys;  ?></span><?php  echo $msg->crowds;  ?></a>
  <?php  $logs=null;  ?>
<?php }else{  ?>
  <h2><?php  echo $msg->welcome;  ?></h2>
  <small><?php  echo $msg->advice;  ?></small>
  <?php  $gbook=$zbp->GetPostByID(trim($cfg->GbookID));  ?>
  <a href="<?php  echo $gbook->Url;  ?>" rel="nofollow" class="more"><?php  echo $msg->message;  ?><span class="zit"><?php  echo $msg->sofa;  ?></span></a>
<?php } ?>
</article>