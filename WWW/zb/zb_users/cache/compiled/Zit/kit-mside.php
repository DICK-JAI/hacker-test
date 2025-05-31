<?php if ($cfg->MobileSide) { ?>
<?php  foreach ( $sidebar6 as $module) { ?>
<div class="pane onlym" id="<?php  echo $module->HtmlID;  ?>">
  <?php if ((!$module->IsHideTitle)&&($module->Name)) { ?><h4 class="zit"><?php  echo $module->Name;  ?></h4><?php } ?>
  <<?php  echo $module->Type;  ?>><?php  echo $module->Content;  ?></<?php  echo $module->Type;  ?>>
</div>
<?php }   ?>
<?php } ?>