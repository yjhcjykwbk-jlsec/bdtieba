<?php
function cmp($a,$b){return isset($a)&&isset($b)&&strcmp($a,$b)==0;}
function c($a){return @iconv('GB2312','UTF-8',$a);}
$_ENV=$_REQUEST;
$MOD=isset($_ENV['mod'])?$_ENV['mod']:'threads';
if(cmp($MOD,"threads")) {//帖子列表
  require "threads.php";
}else if(cmp($MOD,'posts')){//
  require "posts.php";
}else {
  echo "error request";
}
?>
