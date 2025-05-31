<div class="pane<?php if (!in_array($module->FileName,$sideMods)) { ?> hidem<?php } ?>" id="<?php  echo $module->HtmlID;  ?>">
  <?php if ((!$module->IsHideTitle)&&($module->Name)) { ?><h4 class="zit"><?php  echo $module->Name;  ?></h4><?php } ?>
  <<?php  echo $module->Type;  ?>><?php  echo $module->Content;  ?></<?php  echo $module->Type;  ?>>
</div>