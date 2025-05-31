<?php  include $this->GetTemplate('header');  ?>
<section id="wrap">
  <div class="inner">
    <?php  include $this->GetTemplate('kit-topic');  ?>
    <main id="main">
    <?php  foreach ( $articles as $article) { ?>
      <?php  include $this->GetTemplate('post-multi');  ?>
    <?php }   ?>
    <?php  $article=null;  ?>
    <?php  include $this->GetTemplate('pagebar');  ?>
    </main>
    <aside id="side">
      <?php  include $this->GetTemplate('sidebar');  ?>
      <?php  include $this->GetTemplate('kit-mside');  ?>
    </aside>
  </div>
</section>
<?php  include $this->GetTemplate('footer');  ?>