<?php
$s=$_REQUEST;
$action=$s['action'];
if(isset($action)&&$action=='setstar'){
  if(isset($s['tid'])&&isset($s['star'])){
    $star=$s['star'];
    $tid=$s['tid'];
    require "db.php";
    $db=new DB();
    $db->query("update thread_details set star="
    .$star.",timestamp=timestamp where tid=".$tid);
    echo "{status:succeed}";
  }
}
else {
    echo "{status:failed}";
}
?>
