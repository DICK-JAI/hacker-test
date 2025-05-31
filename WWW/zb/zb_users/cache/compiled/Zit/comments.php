<?php if (!$article->IsLock) { ?>
<div id="cmts">
<h3 class="zit kico-da"><?php  echo $cfg->CommentTitle;  ?></h3>
<?php if ($socialcomment) { ?>
  <?php  echo $socialcomment;  ?>
<?php }else{  ?>
<?php  include $this->GetTemplate('commentpost');  ?>
  <label id="AjaxCommentBegin"></label>
  <?php  foreach ( $comments as $key => $comment) { ?>
  <?php  include $this->GetTemplate('comment');  ?>
  <?php }   ?>
  <?php  include $this->GetTemplate('pagebar');  ?>
  <label id="AjaxCommentEnd"></label>
<?php } ?>
</div>
<?php } ?>
