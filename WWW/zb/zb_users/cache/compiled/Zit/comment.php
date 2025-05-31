<blockquote id="cmt<?php  echo $comment->ID;  ?>" class="cmt pane">
  <img src="<?php  echo $comment->Author->Avatar;  ?>" alt="<?php  echo $comment->Author->Name;  ?>" class="avatar">
  <cite><b><a href="<?php  echo $comment->Author->HomePage;  ?>" rel="nofollow" target="_blank" title="<?php  echo $comment->Author->Name;  ?>"><?php  echo $comment->Author->Name;  ?></a></b><small><?php  echo $comment->Time();  ?> | <a href="#postcmt" onclick="zbp.comment.reply(<?php  echo $comment->ID;  ?>);" class="kico-reply"><?php  echo $lang['Zit']['reply'];  ?></a></small></cite>
  <q><?php  echo $comment->Content;  ?></q>
  <?php  foreach ( $comment->Comments as $comment) { ?>
  <?php  include $this->GetTemplate('comment');  ?>
  <?php }   ?>
</blockquote>