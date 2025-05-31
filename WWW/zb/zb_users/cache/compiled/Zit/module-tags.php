<?php  foreach ( $tags as $tag) { ?>
<li class="tags"><a href="<?php  echo $tag->Url;  ?>" title="<?php  echo $tag->Count;  ?><?php  echo $msg->about;  ?>“<?php  echo $tag->Name;  ?>”" class="tag"><?php  echo $tag->Name;  ?> <span><?php  echo $tag->Count;  ?></span></a></li>
<?php }   ?>
