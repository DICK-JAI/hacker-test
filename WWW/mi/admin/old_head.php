<!--<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 
$msecount = $db->counter($_M['table']['infoprompt'], " WHERE lang='{$_M[lang]}' and see_ok='0'", "*");
function is_strinclude($str, $needle, $type = 0){
	if(!$needle) return false;
	$flag = true;
	if(function_exists('stripos')){
		if($type == 0){
			if(stripos($str, $needle) === false){
				$flag = false;
			}
		}else if($type == 1){
			if(strpos($str, $needle) === false){
				$flag = false;
			}
		}
	}else{
		if($type == 0){
			if(stristr($str, $needle) === false){
				$flag = false;
			}
		}else if($type == 1){
			if(strstr($str, $needle) === false){
				$flag = false;
			}
		}		
	}
	return $flag;
}
echo <<<EOT
-->
	 <div class="metcms_top_right">
		<div class="metcms_top_right_box">
			<div class="metcms_top_right_box_div"> 
<!--
EOT;
if($_M['form']['iframeurl']){
	function get($str){
		$data = array();
		$parameter = explode('&',end(explode('?',$str)));
		foreach($parameter as $val){
			$tmp = explode('=',$val);
			$data[$tmp[0]] = $tmp[1];
		}
		return $data;
	}
	$str = $_M['form']['iframeurl'];
	$data = get($str);
	$_M['form']['anyid'] = $data['anyid'];
	$_M['form']['n'] = $data['n'];
}
	$_M['user']['admin_name'] = $metinfo_admin_name;
	$query = "SELECT * from {$_M['table']['admin_table']} WHERE admin_id = '{$metinfo_admin_name}'";
	$user = $db->get_one($query);
	$privilege = array();
	$privilege['admin_op'] = $user['admin_op'];
	if(strstr($user['langok'], "metinfo")) {
		$privilege['langok'] = $_M['langlist']['web'];
	} else {
		$langok = explode('-',$user['langok']);
		foreach($langok as $key=>$val){
			if($val) {
				$privilege['langok'][$val] = $_M['langlist']['web'][$val];
			}
		}
	}
	if(strstr($user['admin_type'], "metinfo")){
		$privilege['navigation'] = "metinfo";
		$privilege['column'] = "metinfo";
		$privilege['application'] = "metinfo";
		$privilege['see'] = "metinfo";
	}else{
		$allidlist = explode('-', $user['admin_type']);
		foreach($allidlist as $key=>$val){
			if(strstr($val, "s")){
				$privilege['navigation'].= str_replace('s','',$val)."|";
			}
			if(strstr($val, "c")){
				$privilege['column'].= str_replace('c','',$val)."|";
			}
			if(strstr($val, "a")){
				$privilege['application'].= str_replace('a','',$val)."|";
			}
			if($val == 9999){
				$privilege['see'] = "metinfo";
			}
		}	
		$privilege['navigation'] = trim($privilege['navigation'], '|');
		$privilege['column'] = trim($privilege['column'], '|');
		$privilege['application'] = trim($privilege['application'], '|');
	}
	$jurisdiction = $privilege;
	$query = "select * from {$_M['table']['admin_column']} order by type desc,list_order";
	$sidebarcolumn = $db->get_all($query);
	$bigclass = array();
	foreach ($sidebarcolumn as $key => $val) {
		if($val['id'] == 68)$val['field'] = '1301';
		if(!is_strinclude($jurisdiction['navigation'], $val['field']) && $jurisdiction['navigation'] != 'metinfo' && $val['field']!=0)continue;
		//需要清理，下面的代码，有些栏目已经多余
		if ((($val['name'] == 'lang_indexcode') || ($val['name'] == 'lang_indexebook') || ($val['name'] == 'lang_indexbbs') || ($val['name'] == 'lang_indexskinset') ) && $_M['config']['met_agents_type'] > 1) continue;
		if ((($val['name'] == 'lang_webnanny') || ($val['name'] == 'lang_smsfuc')) && $_M['config']['met_agents_sms'] == 0) continue;
		if (($val['name'] == 'lang_dlapptips2') && $_M['config']['met_agents_app'] == 0) continue;
		//
		$val['name'] = get_word($val['name']);
		$val['info'] = get_word($val['info']);
		$bigclass[$val['bigclass']] = 1;
		switch ($val['type']) {
			case 1:
				if($bigclass[$val['id']] == 1)$adminnav[$val['id']] = $val;
			break;
			case 2:
				if (strstr($val['url'],"?")) {
					$val['url'] .= '&anyid='.$val['id'].'&lang='.$_M['lang'];
				}else{
					$val['url'] .= '?anyid='.$val['id'].'&lang='.$_M['lang'];
				}
				$val['url'] = $_M['url']['site_admin'].$val['url'];
				$adminnav[$val['id']] = $val;
			break;
		}
	}
if($_M['form']['anyid'] == 32 || $_M['form']['anyid'] == 33) {
	$_M['form']['anyid'] = '29';
}
if($_M['form']['anyid'] == '44'){
	foreach ($adminapplist as $key => $val) {
		if ($val['m_name'] == $_M['form']['n']) {
			$nav_3 = $val;
			$nav_3 ['name'] = get_word($val['appname']);
			break;
		}
	}
	if(!$nav_3)$nav_3 = $adminnav[$_M['form']['anyid']];
} else {
	$nav_3 = $adminnav[$_M['form']['anyid']];
}
$weizhi = '';
if(!$_M['form']['anyid'])$weizhi = $_M['word']['background_page'];
$a=$adminnav[$adminnav[$_M['form']['anyid']]['bigclass']]['name'];
$a=$$a;
if($_M['form']['anyid'] == 44 && M_NAME!='myapp')$adminnav[$adminnav[$_M['form']['anyid']]['bigclass']]['name'] = "<a href=\"{$adminnav[44]['url']}\">{$adminnav[44]['name']}";
echo <<<EOT
-->
				<div class="position">
					<i class="fa fa-globe"></i>
					{$_M['langlist']['web'][$_M['lang']]['name']}
					<i class="fa fa-angle-right"></i>
					{$a}
					{$weizhi}
<!--
EOT;
if($_M['form']['anyid']){
echo <<<EOT
-->
					<i class="fa fa-angle-right"></i>
					<a href="{$nav_3[url]}">{$$nav_3['name']}</a>
<!--
EOT;
}
echo <<<EOT
-->
				</div>
				<ol>
<!--
EOT;
$_M['user']['langok'] = $privilege['langok'];
$weblangok = count($_M['user']['langok'])>1?1:0;
$weblang = $_M['langlist']['web'][$_M['lang']];
if($weblangok){
echo <<<EOT
-->
					<li class="list lang">
						<a href="#" class="lang_name">{$weblang['name']}<i class=" fa fa-caret-down"></i></a>
						<dl>
<!--
EOT;
foreach($_M['user']['langok'] as $key=>$val){
$url_now ='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
if(!strstr($url_now, "lang=")) {
	$val['url'] = $_M[url][site_admin]."index.php?lang={$val['mark']}";
} else {
	$val['url'] = str_replace(array("lang={$_M['lang']}", "lang%3D{$_M['lang']}"), array("lang={$val['mark']}", "lang%3D{$val['mark']}"), $url_now);
}
$val['url'] .= "&switch=1";
if(strstr($val['url'], "/content/") && strstr($val['url'], "class1")) {
	$val['url'] = $_M[url][site_admin]."content/content.php?anyid=29&lang={$val['mark']}&switch=1";
}
echo <<<EOT
-->
							<dd><a href="{$val['url']}">{$val[name]}</a></dd>
<!--
EOT;
}
echo <<<EOT
-->
							<dd><a href="{$_M[url][site_admin]}system/lang/lang.php?anyid=10&langaction=add&lang={$_M[lang]}&cs=1" class="addlang"><i class="fa fa-plus"></i>{$_M['word']['langweb']}</a></dd>
						</dl>
					</li>
<!--
EOT;
}
echo <<<EOT
-->
					<li class="list mesage"><a href="{$_M[url][site_admin]}index.php?n=system&c=news&a=doindex&lang={$_M[lang]}"><i class="fa fa-envelope-o"></i>
					<span class="mes_{$msecount}">{$msecount}</span>
					</a>
					
					</li>
					<li class="list lang">
						<a href="#" class="lang_name">{$_M['user']['admin_name']}<i class=" fa fa-caret-down"></i></a>
						<dl>
							<dd><a href="{$_M[url][site_admin]}admin/editor_pass.php?anyid=47&lang={$_M[lang]}">{$_M['word']['modify_information']}</a></dd>
							<dd><a target="_top" href="{$_M[url][site_admin]}login/login_out.php">{$_M[word][indexloginout]}</a></dd>
						</dl>
					</li>
					
					<li class="list lang sq" {$met_agents_display}>
<!--
EOT;
$query = "SELECT * FROM {$_M['table']['otherinfo']} WHERE id='1'";
$key_info = $db->get_one($query);
if ($key_info['authpass'] && $key_info['authcode']) {
	list($domain, $tempdomain) = explode('|', $key_info['info3']);
	if(is_strinclude($_M['url']['site'], $domain) || is_strinclude($_M['url']['site'], $tempdomain)){
		$otherinfoauth = $key_info;
	}else{
		$otherinfoauth = '';
	}
} else {
	$otherinfoauth = '';
}
if($_M[config][met_agents_type] < 2) {
if(!$otherinfoauth) {
echo <<<EOT
-->				
						<a href="#" class="lang_name">{$_M['word']['indexcode']}<i class=" fa fa-caret-down"></i></a>
						<dl>
							<dd>{$_M['word']['sys_authorization']}</dd>
							<dd><a href="{$_M['url']['site_admin']}index.php?lang={$_M[lang]}&n=system&c=authcode&a=doindex">{$_M['word']['sys_authorization1']}</a></dd>
							<dd><a target="_blank" class="liaojie" href="http://www.metinfo.cn/web/product.htm">{$_M['word']['sys_authorization2']}</a></dd>
						</dl>
<!--
EOT;
} else {
echo <<<EOT
-->	
						<a href="#" class="lang_name">{$_M['word']['indexcode']}<i class=" fa fa-caret-down"></i></a>
						<dl>
							<dd>{$_M['word']['authorization_level']}</dd>
							<dd><a href="#" style="margin-top:5px;">{$otherinfoauth['info1']}</a></dd>
							<dd><a class="liaojie" target="_blank" href="http://www.metinfo.cn/code/code.php?url={$_M['url']['site']}">{$_M['word']['technical_support']}</a></dd>
							<dd><a class="nobo" href="{$_M['url']['site_admin']}index.php?lang={$_M[lang]}&n=system&c=authcode&a=doindex">{$_M['word']['entry_authorization']}</a></dd>
						</dl>
<!--
EOT;
}
}
echo <<<EOT
-->
			

					</li>
				</ol>
				<div class="metcms_top_right_box_border"></div>
			</div>
		</div>
	 </div>
<SCRIPT language=JavaScript>  
var langtime;
	$(".metcms_top_right_box li.lang").hover(function(){
		clearTimeout(langtime);
		var dl = $(this).find("dl");
		langtime = setTimeout(function () { dl.show();  }, "200");
	},function(){
		clearTimeout(langtime);
		var dl = $(this).find("dl");
		dl.hide();
	});
	var str = window.parent.document.URL; 
	var s = str.indexOf('lang='+lang);
	var str1 = window.location.href;
	var s1 = str1.indexOf('switch=1');
	if(s == '-1' && s1 != '-1'){
		str = str.replace(/(lang=[^#]*#)/g,"lang="+lang+"#");
		parent.location.href=str;
	}
</SCRIPT>
<!--
EOT;
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>