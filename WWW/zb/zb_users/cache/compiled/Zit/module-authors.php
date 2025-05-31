<?php  foreach ( $authors as $author) { ?>
<li class="stock"><a href="<?php  echo $author->Url;  ?>" title="<?php  echo $author->Name;  ?><?php  echo $msg->logs;  ?>" class="kico-portrait"><?php  echo $author->Name;  ?>  <mark><?php  echo $author->Articles;  ?></mark></a></li>
<?php }   ?>
