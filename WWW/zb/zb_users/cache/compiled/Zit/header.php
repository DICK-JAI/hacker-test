<!DOCTYPE html>
<html xml:lang="<?php  echo $lang['lang_bcp47'];  ?>" lang="<?php  echo $lang['lang_bcp47'];  ?>">
<head>
  <meta charset="utf-8">
  <title><?php  echo $title;  ?> - <?php  echo $name;  ?></title>
<?php  include $this->GetTemplate('seo');  ?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="theme" content="吉光片羽,jgpy.cn">
  <meta name="generator" content="<?php  echo $zblogphp;  ?>">
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">
  <meta http-equiv="Cache-Control" content="no-siteapp">
  <link rel="shortcut icon" href="<?php  echo $host;  ?>favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="<?php  echo $host;  ?>zb_users/theme/<?php  echo $theme;  ?>/style/<?php  echo $style;  ?>.css?v=<?php  echo $cfg->Custom;  ?>" type="text/css" media="all">
  <script src="<?php  echo $host;  ?>zb_system/script/jquery-2.2.4.min.js" type="text/javascript"></script>
  <script src="<?php  echo $host;  ?>zb_system/script/zblogphp.js" type="text/javascript"></script>
  <script src="<?php  echo $host;  ?>zb_system/script/c_html_js_add.php" type="text/javascript"></script>
  <script src="<?php  echo $host;  ?>zb_users/theme/<?php  echo $theme;  ?>/script/custom.js?v=<?php  echo $cfg->Custom;  ?>" type="text/javascript"></script>
<?php  echo $header;  ?>
<?php if ($type=='index'&&$page=='1') { ?>
  <link rel="alternate" type="application/rss+xml" href="<?php  echo $feedurl;  ?>" title="<?php  echo $name;  ?>">
  <link rel="EditURI" type="application/rsd+xml" title="RSD" href="<?php  echo $host;  ?>zb_system/xml-rpc/?rsd">
  <link rel="wlwmanifest" type="application/wlwmanifest+xml" href="<?php  echo $host;  ?>zb_system/xml-rpc/wlwmanifest.xml">
<?php } ?>
</head>

<body class="<?php  echo $type;  ?>">
<header id="face">
  <div class="inner">
    <h2 id="logo"><a href="<?php  echo $host;  ?>" title="<?php  echo $cfg->Logo?$cfg->Logo:$name;  ?>" class="zit"><?php  echo $cfg->Logo?$cfg->Logo:$name;  ?></a></h2>
    <nav id="menu">
      <ul>
        <?php  if(isset($modules['navbar'])){echo $modules['navbar']->Content;}  ?>
      </ul>
    </nav>
    <div id="seek" class="invis">
        <form name="search" method="post" action="<?php  echo $host;  ?>zb_system/cmd.php?act=search">
          <input name="q" type="text" placeholder="<?php  echo $msg->keyword;  ?>"><button type="submit" class="kico-magnify"><dfn><?php  echo $msg->search;  ?></dfn></button>
          <p><?php  if(isset($modules['zit-searchtag'])){echo $modules['zit-searchtag']->Content;}  ?> <i id="shuts" class="kico">&times;</i></p>
        </form>
    </div>
  </div>
</header>
<section id="banner">
  <b id="backdrop"></b>
  <div class="inner">
    <h2 id="motto" class="zit"><?php  echo $motto;  ?></h2>
  </div>
</section>