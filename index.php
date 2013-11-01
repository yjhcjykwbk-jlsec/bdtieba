<?php
function cmp($a,$b){return isset($a)&&isset($b)&&strcmp($a,$b)==0;}
//重新包装http请求发到iframe
$_ENV=$_REQUEST;
$MOD=isset($_ENV['mod'])?$_ENV['mod']:'threads';
$PN=isset($_ENV['pn'])?$_ENV['pn']:1;
if(isset($_ENV['cid'])) $CID=$_ENV['cid'];
function url($name,$value){
  if(isset($value)) return "&".$name."=".$value;
  return "";
}
$IFRAMESRC="portal.php?".url("mod",$MOD).url("pn",$PN);
if(isset($CID)) $IFRAMESRC.=url("cid",$CID);
require "iframe.php";
?>
