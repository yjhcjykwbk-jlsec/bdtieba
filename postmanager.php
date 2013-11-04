<?php
if(!isset($DB)){
  echo "no db";
  return;
}
function getThreadOrder($tid){
  //获取主题时间排序序号
  //该部分被$TPN 替代
  global $DB;
  $sql="set @i=0";
  $DB->query($sql);
  $sql="select temp.order from (select @i:=@i+1 as `order`,tid from threadseq"  //threadseq是一个view
    .") as temp where temp.tid=".$tid;
  $tmp=$DB->get($sql);
  // $THREAD['seqnum']=$tmp['0']['order'];
  return $tmp['0']['order'];
}
//增删改查
if($MOD=="posts"&&isset($PN)&&isset($TID)){
  $num=($PN-1)*30;
  //获取帖子
  $sql="select * from posts,threads where ".
    " posts.postid=threads.postid and threads.tid=".$TID.
    " order by posts.timestamp limit ".$num.",30 ";
  $POSTLIST=$DB->get($sql);
  //获取楼中楼
  // $POSTLIST=array();
  // foreach($tmp as $i =>$post){
    // $POSTLIST[$post['postid']]=$post;
  // } 
  // $sql="select * from lzls where postid in ".
      // "(select postid from threads where tid=".$TID.")";
    // $lzls=$DB->get($sql);
  // foreach($POSTLIST as $i=>$tmp)
    // $POSTLIST[$i]['lzl']=array();
  // foreach($lzls as $i =>$tmp){
    // $postid=$tmp['postid'];
    // $POSTLIST[$postid]['lzl']+=$tmp;
  // }

  //获取回复个数
  $sql="select * from thread_details where tid=".$TID;
  $tmp=$DB->get($sql);
  $THREAD=$tmp[0];
  $THREAD['postnum']=count($POSTLIST);


  //获取帖子楼中楼
  foreach($POSTLIST as $i =>$tmp){
    $sql="select * from lzls where postid=".$tmp['postid'];
    $DB->query($sql);
    $lzls=$DB->get_rows_array();
    $POSTLIST[$i]['lzl']=$lzls;
  }
//  echo "<pre>";
//  var_dump($POSTLIST,true);
//  echo "</pre>";
  //选择主题，从start个开始
}

else if($MOD=="threads"&&isset($PN)&&!isset($CID)){
  $num=($PN-1)*$NUM;
  $THREADLIST=$DB->get("select * from thread_details order by timestamp desc".
      " limit ".$num.",$NUM");
  //获取每个帖子的回复数量
  foreach($THREADLIST as $i=>$tmp){
    $num=$DB->get("select count(*) as cnt from threads where tid=".$tmp['tid']);
    $THREADLIST[$i]['postnum']=$num['0']['cnt'];
  }
  $num=$DB->get("select count(*) as cnt from thread_details");
  $THREADNUM=$num['0']['cnt'];
}

else if($MOD=="threads"&&isset($PN)&&isset($CID)){
  $num=($PN-1)*$NUM;
  $THREADLIST=$DB->get("select * from thread_details,jinpin where thread_details.jinpinname=jinpin.jinpinname".
      " and jinpin.id=".$CID." order by timestamp desc".
      " limit ".$num.",$NUM");
  $JINPINLIST=$DB->get("select * from jinpin");
  //获取每个帖子的回复数量
  foreach($THREADLIST as $i=>$tmp){
    $num=$DB->get("select count(*) as cnt from threads where tid=".$tmp['tid']);
    $THREADLIST[$i]['postnum']=$num['0']['cnt'];
  }
  $num=$DB->get("select count(*) as cnt from thread_details,jinpin where thread_details.jinpinname=jinpin.jinpinname".
      " and jinpin.id=".$CID);
  $THREADNUM=$num['0']['cnt'];
} 
?>
<?php
//更新所有主题最后编辑时间：
// create view temp as select tid,max(threads.timestamp) as time from threads group by tid  ;
// update thread_details,temp set thread_details.timestamp=temp.time where thread_details.tid=temp.tid  ;
?>
