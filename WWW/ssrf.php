<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
 <html>
 <head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>SSRF</title>
 </head>
 <body>
远程图片加载器
<form action="" method="POST">
请输入图片地址：<input type='text' name='url'>
 <input type='submit' value="提交">
 </form>
 </body>
 <?php
 $_POST['url'];
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, $_POST['url']);
 curl_setopt($ch, CURLOPT_HEADER, false);
 curl_exec($ch);
 curl_close($ch);
 ?>