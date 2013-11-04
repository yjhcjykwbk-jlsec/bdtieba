  <div class="frs_content clearfix">
      <div class="contet_wrap" id="contet_wrap">
          <div id="content_leftList" class="content_leftList clearfix">
              <ul id="thread_list" class="threadlist">
                  <?php $i=0;foreach($THREADLIST as $THREAD){
                    $THREAD['title']=c($THREAD['title']);                                  
                    if($i++%2==0){ ?>
                  <li class="j_thread_list" data-field="">
                  <?php }else{?>
                  <li class="j_thread_list threadlist_li_gray" data-field="">
                  <?php }?>
                      <div class="threadlist_li_left j_threadlist_li_left">
                          <div title="<?php echo $THREAD['postnum'];?>个回复" class="threadlist_rep_num j_rp_num"><?php echo $THREAD['postnum'];?></div>
                      </div>
                      <div class="threadlist_li_right j_threadlist_li_right">
                          <div class="threadlist_lz clearfix">
                              <div class="threadlist_text threadlist_title j_th_tit  notStarList ">
                      <!--$TPN is for threads page's pn-->
                                  <a href="?kword=<?php echo $DBNAME;?>&mod=posts&tpn=<?php echo $PN; ?>&num=<?php echo $NUM;?>&tid=<?php echo $THREAD['tid'];?>" title="<?php echo $THREAD['title'];?>"  class="j_th_tit">
                                    <?php if($THREAD['jinpinname']!=''){?> <span><img src="http://tb1.bdstatic.com/tb/static-frs/img/icon_bright/jing.gif"></span><?php }?><?php echo $THREAD['title'];?></a>
                              </div>
                              <!-- 加星 -->
                              <div class="star_bg fl" id="star_div">
                              <div id="a_stars" class="<?php echo $THREAD['tid'];?>"style="background-position: <?php
                              $tmp=$THREAD['star'];echo (26*(round($tmp)-5));?>px center;"
                              ></div>
                              <em id="m"></em>
                              </div>
                          </div>
                          <div class="j_threadlist_detail threadlist_detail clearfix">
                              <div class="threadlist_text">
                                  <div class="threadlist_abs threadlist_abs_onlyline"><?php echo c($THREAD['digest']);?>
                                  </div>
                              </div>
                              <div class="threadlist_author">
                                  <span class="tb_icon_author_rely j_replyer" title="最后回复人:" style="float:left"></span>
                                  <span class="threadlist_reply_date j_reply_data" title="最后回复时间"><?php echo  $THREAD['timestamp']; ?></span>
                              </div>

                          </div>
                      </div>
                      <div class="clear"></div>
                  </li>
                <?php }?>
              </ul>

              <div id="frs_list_pager" class="pager clearfix">
              <?php
                $pnum=$THREADNUM;
                //$page=$PN-8>0?$PN-8:1;
                $mnum=(int)($pnum/$NUM+1);
                $page=1;
                $i=0;      
                while($page<$mnum){
                  if($page==$PN){    
                  ?>
                  <span style="font:bold 14px arial" ><?php echo $PN;?></span>
                  <?php }else{?>
                  <a href="?kword=<?php echo $DBNAME;?>&mod=threads&pn=<?php echo $page;?>&num=<?php echo $NUM ?><?php if(isset($CID)) echo "&cid=".$CID;?>"><?php echo $page;?></a>
                  <?php }
                  $page++;$i++;
                }?>
                <a href="?kword=<?php echo $DBNAME;?>&mod=threads&pn=<?php echo $mnum?>&num=<?php echo $NUM ?><?php if(isset($CID)) echo "&cid=".$CID;?>" class="last">尾页</a>
              </div>
          </div>
      </div>
  </div>
