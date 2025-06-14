<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

load::sys_class('admin');
load::sys_class('curl');
load::sys_func('file');

class download extends admin {

	public $curl;
	protected $info;
	protected $savedir;
	protected $getdir;
	
	function __construct() {
		global $_M;
		parent::__construct();
		$this->curl = new curl();
		$this->analyze($_M['form']['data']);
		$this->savedir = PATH_WEB."{$_M['config'][met_adminfile]}/update/{$this->info['type']}/{$this->info['no']}/";
	}
	
	public function dlfile() {
		global $_M;
		$dlfile = load::sys_class('dlfile', 'new');
		return $dlfile;
	}
	
	public function dodownload() {
		global $_M;
		switch($this->info['action']) {
			case 'doc' : 
				$data = $this->doc();
			break;
			case 'check' : 
				$data = $this->checkpower();
			break;
			case 'dl' : 
				$data = $this->dl();
			break;
			case 'install' : 
				$data = $this->install();
			break;
			case 'complete' : 
				$data = $this->complete();
			break;
		}
		jsoncallback($data);
	}

	public function doc() {
		global $_M;
		$this->curl->set('file', 'index.php?n=platform&c=system&a=dodoc');
		$post = array('type'=>$this->info['type'], 'no'=>$this->info['no'], 'ver'=>$app['ver'], 'cmsver'=>$_M['config']['metcms_v'], 'user_key'=>$_M['config']['met_secret_key']);
		$getdata = $this->curl->curl_post($post);
		list($suc, $html) = explode('|', $getdata);
		if ($suc == 'suc') {
			return $this->suc_data('check_doc', '1', "{$_M['word']['file_permissions']}....", 0, 'confirm', $this->confirm("升级文档：", $html, $_M['word']['updatelater'], $_M['word']['updatenow']));
		}else{
			return $this->fail_data($suc);
		}
	}
	public function checkfilepower($file) {
		global $_M;
		if(makefile($file, false)){	
			return getfilepower($file);
		}else{
			return false;
		}
	}
	public function checkdllistpower() {
		global $_M;
		$file = array();
		require_once $this->savedir.'dllist.php';
		foreach ($dllist as $key => $val) {
			if(preg_match('/^((file)|(file_.*))\/(.*)$/', $val, $match)){
				$file[] = preg_replace('/^admin\/(.*)$/', $_M['config']['met_adminfile'].'/'.'\\1', $match[4]);
			}
		}
		$str = '';
		$file = array_unique($file);
		foreach($file as $key => $val){
			if(!$this->checkfilepower($val)){
				$str.="{$val}<br />";
			}
		}
		if($str){
			return $_M['word']['following_documents'].'<!>'.$_M['word']['following_documents'].$str;
		}else{
			return false;			
		}

	}
	public function checkpower() {
		global $_M;
		$updatefile = PATH_WEB.$_M['config']['met_adminfile'].'/update/test/test.txt';
		deldir(PATH_WEB.$_M['config']['met_adminfile'].'/update/test/');
		if ($this->checkfilepower($updatefile)) {
			/*请求并验证下载权限*/
			$this->curl->set('file', 'index.php?n=platform&c=system&a=docheckpower');
			$app['ver'] = $_M['config']['metcms_v'];
			if($this->info['type'] != 'cms'){
				$query = "SELECT * FROM {$_M['table']['applist']} ";
				$app = DB::get_one($query);
			}
			$query = "SELECT * FROM {$_M['table']['otherinfo']} where id=1";
			$th = DB::get_one($query);
			$authkey = $th['authpass'];
			$authcode= $th['authcode'];
			$post = array('type'=>$this->info['type'], 'no'=>$this->info['no'], 'ver'=>$app['ver'], 'cmsver'=>$_M['config']['metcms_v'], 'user_key'=>$_M['config']['met_secret_key'], 'authkey'=>$authkey, 'authcode'=>$authcode);
			$getdata = $this->curl->curl_post($post);
			list($suc, $this->info['checknum']) = explode('|', $getdata);
			//echo $this->curl->curlerror;
			if ($suc == 'suc') {
				$this->del_dl_file();
				/*下载安装包并检测安装的文件，是否有权限*/
				$dlfile = $this->dlfile();
				//补充代码----------检测dllist.php下载权限
				$re = $dlfile->dlfile('dllist.php', $this->savedir.'dllist.php', $this->info['checknum']);
				if ($re == 1) {
					//补充代码----------检测dllist.php文件列表中文件权限
					$nopower = $this->checkdllistpower();
					if($nopower){
						list($nopower_t, $nopower_c)=explode('<!>', $nopower);
						return $this->fail_data($nopower_t, $nopower_c);
					}else{
						$html = "{$_M['word']['download']}...";
						return $this->suc_data('dl', 0, $html);
					}
				} else {
					return $this->fail_data($re);
				}
			} else {
				return $this->fail_data($suc);
			}
		}else{
			return $this->fail_data("{$_M['config']['met_adminfile']}/update/{$_M['word']['write_permission']}");
		}
		return $data;
	}
	
	public function dl() {
		global $_M;
		$dlfile = $this->dlfile();
		require_once $this->savedir.'dllist.php';
		$num = $this->info['step'];
		if ($dllist[$num]) {
			$re = $dlfile->dlfile($dllist[$num], $this->savedir.$dllist[$num], $this->info['checknum']);
			if ($re == 1) {
				$html = "{$_M['word']['download']}...".floor((($num)/count($dllist))*100)."% ({$_M['word']['download_prompt']})";
				return $this->suc_data('dl', $this->info['step']+1, $html);
			} else {
				return $this->fail_data("{$_M['word']['download_interrupt']},{$_M['word']['possible_reasons']}:".$re);
			}
		} else {
			$html = $_M['word']['installation'];
			return $this->suc_data('install', 1, $html);
		}
	}
	
	public function install() {
		global $_M;

		require_once $this->savedir.'install.class.php';
		$install = new install();
		@$install->step = $this->info['step'];
		if(method_exists($install, 'getfile')){
			$copydir = $install->getfile();
		}
		
		$copydir = $copydir ? $copydir : 'file/';
		
		//安装文件
		if ($copydir != 'notcopy') {
			$copyfile = $this->savedir.$copydir;
			$resource = opendir($copyfile);
			while (($file = readdir($resource))!== false) {
				if($file == '.' || $file == '..'){
					continue;
				}
				if (is_dir($copyfile.$file)) {
					if ($file == 'admin') {
						copydir($copyfile."admin", PATH_WEB.$_M['config']['met_adminfile']);
					}else{
						copydir($copyfile.$file, PATH_WEB.$file);
					}
				} else {
					copyfile($copyfile.$file, PATH_WEB.$file);
				}
			}
		}
		//安装数据
		if ($this->info['type'] == 'cms') {
			$metcms_ver = $_M[config][metcms_v]."|".$syslist[$_M[config][metcms_v]];
			$authinfo=DB::get_one("SELECT * FROM $met_otherinfo where id=1");
			$this->curl->set('host', 'http://api.metinfo.cn/');
			$this->curl->set('file', 'dl/record_dl.php');
			$post_data = array('cmd'=>'sys','url'=>$_M[url][site],'code'=>$authinfo['authcode'],'key'=>$authinfo['authpass'],'ver'=>$metcms_ver);
			$this->curl->curl_post($post_data);
		}
		$re = $install->dosql();
		if ($re == 'complete' || !$re) {
			return $this->suc_data('complete', 0, $_M['word']['installation_complete']);
		} else if ($re == 'next') {
			if(method_exists($install, 'html')){
				$html_re = $install->html();
			}
			if($html_re){
				$html = $html_re;
			}else{
				$html = "{$_M['word']['installation']}...";
			}
			return $this->suc_data('install', $this->info['step']+1, $html); 
		} else if ($re == 'recheck') {
			return $this->suc_data('check', 1, $_M['word']['detection'].'...');
		}else {
			return $this->fail_data($re);
		}
	}
	public function complete() {
		global $_M;
		$this->del_dl_file();
		if ($this->info['type'] == 'cms') {
			return $this->suc_data('end', 0, "{$_M['word']['installation_complete']}，3{$_M['word']['seconds_background']}", 1, 'refresh'); 
		}
		if ($this->info['type'] == 'app') {
			$this-> add_power($this->info['no']);
			$getapp = load::mod_class('myapp/class/getapp', 'new');
			$app = $getapp->get_oneapp($this->info['no']);
			$html = "<a href=\"{$app['url']}\">{$_M['word']['dlapptips5']}</a>";
			return $this->suc_data('end', 0, $html); 
		}
		if ($this->info['type'] == 'tem') {
			$query = "SELECT * FROM {$_M['table']['skin_table']} ORDER BY id DESC";
			$tem = DB::get_one($query);
			$html = "<a target=\"_blank\" href=\"{$_M['url']['adminurl']}n=theme&c=theme&a=doindex&mobile={$tem['devices']}&anyid=70&lang={$_M['lang']}\">{$_M['word']['configuratio_template']}</a>";
			return $this->suc_data('end', 0, $html); 
		}
	}
	protected function analyze($s) {
		global $_M;
		list($this->info['type'], $this->info['no'], $this->info['action'], $this->info['step'], $this->info['checknum']) = explode('|', $s);		
	}
	protected function fail_data($html, $confirm, $dojs = 'fail') {
		global $_M;
		$html = $this->errorinfo($html);
		$data['data'] = "{$this->info['type']}|{$this->info['no']}|{$this->info['action']}|{$this->info['step']}|{$this->info['checknum']}";
		$data['suc'] = 0;
		$data['html'] = $_M['word']['installation_errors'];
		$data['jsdo'] = $dojs;
		$data['click'] = 0;
		if(!$confirm){
			$confirm = $html;
			$html = '';
		}
		$confirm = $this->confirm($_M['word']['installation_errors'], $confirm, $_M['word']['give_installation'], $_M['word']['try_again']);
		$data['confirm'] = $confirm;
		return $data;
	}
	protected function errorinfo($errorno) {
		global $_M;
		switch($errorno){
			case '' :
				return $_M['word']['link_remote'];
			break;
			case 'nohost' :
				return $_M['word']['link_remote'];
			break;
			case 'error_code' :
				return $_M['word']['permission_download'];
			break;
			case 'error_maintain' :
				return "{$_M['word']['system_maintenance']}...";
			break;
		}
		return 	$errorno;
	}
	protected function suc_data($action, $step, $html, $click = 1, $jsdo ='', $confirm = '') {
		global $_M;
		
		if($action == 'end'){
			$data['data'] = 'end';
		}else{
			$data['data'] = "{$this->info['type']}|{$this->info['no']}|{$action}|{$step}|{$this->info['checknum']}";
		}
		$data['suc'] = 1;
		$data['html'] = $html;
		$data['jsdo'] = $jsdo;
		$data['click'] = $click;
		$data['confirm'] = $confirm;
		return $data;
	}
	
	protected function confirm($title, $html, $cancel, $confirm) {
		global $_M;
		$privilege = background_privilege();
		if($privilege['navigation'] == 'metinfo' || strstr($privilege['navigation'], '1801')) {
			$jurisdiction = '1';
		}
		return "
		<div class='v52fmbx' style='border-bottom: none;'>
			<h3 class='v52fmbx_hr'>{$title}</h3>
			<dl>
				<dd class='ftype_input'>
					{$html}
				</dd>
			</dl>
			<br>
			<dl class='noborder'>
				<dd style='margin-left: 200px;'>
					<input id='olupdate_type' name='olupdate_type' type='hidden' value='{$jurisdiction}' />
					<input type='submit' name='remodal-cancel' value='{$cancel}' class='submit'>
					<input type='submit' name='remodal-confirm' value='{$confirm}' class='submit'>
				</dd>
			</dl>
		</div>";
	}
	
	protected function del_dl_file() {
		global $_M;
		if($_M['config']['met_adminfile'] && $this->info['type'] && $this->info['no']){
				deldir(PATH_WEB.$_M['config']['met_adminfile'].'/update/'.$this->info['type'].'/'.$this->info['no'].'/');
		}
	}
	
	protected function add_power($no) {
		global $_M;
		$query = "SELECT * FROM {$_M['table']['admin_table']} WHERE usertype='3'";
		$admins = DB::get_all($query);
		foreach($admins as $key=>$val) {
			if(is_strinclude($val['admin_type'], 's1505') && !is_strinclude($val['admin_type'], 'a'.$no)){
				$val['admin_type'] = str_replace('s1505', 's1505-a'.$no, $val['admin_type']);
				$query = "UPDATE {$_M['table']['admin_table']} SET admin_type='{$val['admin_type']}' WHERE id='{$val['id']}'";
				DB::query($query);
			}
		}
	}

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>