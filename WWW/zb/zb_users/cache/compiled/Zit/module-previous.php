<?php  foreach ( $articles as $article) { ?>
<li class="illus"><a href="<?php  echo $article->Url;  ?>" title="<?php  echo $article->Title;  ?>"><?php if ($article->Cover) { ?><img src="<?php  echo $article->Cover;  ?>" alt="<?php  echo $article->Title;  ?>" class="cover"><?php } ?><small><?php  echo $article->Time('Y-m-d');  ?></small><?php  echo $article->Title;  ?></a></li>
<?php }   ?>