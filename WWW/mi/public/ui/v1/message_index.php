<!--<?php
require_once template('head'); 
require_once template('sidebar');
$messagelist=metlabel_messagelist();
$fromarray=metlabel_message();
echo <<<EOT
-->
       <div id="messagelist">
            {$messagelist}
			{$page_list}
            <form enctype='multipart/form-data' method='POST' class="ui-from" name='myform' action='message.php?action=add'>
				<div class="v52fmbx">
				<input type='hidden' name='lang' value='{$lang}' />
				<h3 class="v52fmbx_hr">{$lang_SubmitInfo}</h3>
<!--
EOT;
dump($fromarray);
foreach($fromarray as $key=>$val){
if(strstr($val[type_class], "ftype_code")){
	$val[input] = $val[type_html];
}
echo <<<EOT
-->
				<dl>
					<dt class="ftype_select">{$val[name]}</dt>
					<dd class="{$val[type_class]}">
						<div class="fbox">
							{$val[input]}
						</div>
						<span class="tips">{$val[description]}</span>
					</dd>
				</dl>
<!--
EOT;
}
echo <<<EOT
-->
				<dl class="noborder">
					<dt>&nbsp;</dt>
					<dd>
						<input type="submit" name="submit" value="{$lang_Submit}" class="submit" />
					</dd>
				</dl>
				</div>
			</form>
        </div>
<!--
EOT;
require_once template('gap');
require_once template('foot'); 
?>