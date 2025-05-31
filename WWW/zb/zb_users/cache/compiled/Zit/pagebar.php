<?php if ($pagebar) { ?>
<nav id="pagi">
<?php  foreach ( $pagebar->buttons as $k=>$v) { ?>
  <?php if ($pagebar->PageNow==$k) { ?>
  <b class="zit"><?php  echo $k;  ?></b>
  <?php }else{  ?>
  <a href="<?php  echo $v;  ?>"><?php  echo $k;  ?></a>
  <?php } ?>
<?php }   ?>
</nav>
<?php } ?>