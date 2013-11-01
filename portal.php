<?php
function cmp($a,$b){return isset($a)&&isset($b)&&strcmp($a,$b)==0;}
function c($a){return @iconv('GB2312','UTF-8',$a);}
function p($a){print "<pre>";print_r($a);print "</pre>";}
//解析http请求
$_ENV=$_REQUEST;
$MOD=isset($_ENV['mod'])?$_ENV['mod']:'threads';
$PN=isset($_ENV['pn'])?$_ENV['pn']:1;
//每页显示主题个数
$NUM=isset($_ENV['num'])?$_ENV['num']:100;
//贴吧名字
$DBNAME=isset($_ENV['kword'])?$_ENV['kword']:'tieba';
if(isset($_ENV['cid'])) $CID=$_ENV['cid'];
//分发不同模块
if(cmp($MOD,"threads")) {//帖子列表
  require "threads.php";
}else if(cmp($MOD,'posts')){//
  require "posts.php";
}else {
  echo "error request!";
  echo "<pre>usage example:\n"
  ." ?mod=threads&pn=5&num=100\n"
  ."or ?mod=posts&pn=2</pre>";
}
?>
