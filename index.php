<?php
function cmp($a,$b){return isset($a)&&isset($b)&&strcmp($a,$b)==0;}
//重新包装http请求发到iframe
$_ENV=$_REQUEST;
// $MOD=isset($_ENV['mod'])?$_ENV['mod']:'threads';
// $PN=isset($_ENV['pn'])?$_ENV['pn']:1;
// if(isset($_ENV['cid'])) $CID=$_ENV['cid'];
// function url($name,$value){
  // if(isset($value)) return "&".$name."=".$value;
  // return "";
// }
function r(){
  $url="";
  foreach($_ENV as $key=>$value){
    $url.="&".$key."=".$value;
  }
  return $url;
}
$IFRAMESRC="portal.php?".r();
$IFRAMEWIDTH=780;
require "iframe.php";
?>
