<?php if ($cfg->Profile) { ?>
<div class="pane hidem" id="minfo">
  <img src="<?php  echo $author->Avatar;  ?>">
  <h3><a href="<?php  echo $author->Url;  ?>"><?php  echo $author->Name;  ?></a></h3>
  <?php if ($author->Intro) { ?><p><?php  echo $author->Intro;  ?></p><?php } ?>
</div>
<?php } ?>