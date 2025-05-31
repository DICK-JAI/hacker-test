<?php  include $this->GetTemplate('header');  ?>
<section id="wrap">
  <div class="inner">
  <?php if ($article->Type==ZC_POST_TYPE_ARTICLE) { ?>
  <?php  include $this->GetTemplate('post-single');  ?>
  <?php }else{  ?>
  <?php  include $this->GetTemplate('post-page');  ?>
  <?php } ?>
  </div>
</section>
<?php  include $this->GetTemplate('footer');  ?>
