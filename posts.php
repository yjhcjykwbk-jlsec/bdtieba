<?php 
    require_once "db.php";
    $DB=new DB();
    if(isset($_ENV['pn']))
      $PN=$_ENV['pn'];
    else $PN=1;
    if(isset($_ENV['tid'])){
      $TID=$_ENV['tid'];
      $ACTION="getPosts";
      require "postmanager.php";
    }else return;
?>
<html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
    <base target="_parent">
    <meta charset="utf-8">
    <title>posts</title>

    <link rel="apple-touch-icon" href="http://tb2.bdstatic.com/tb/wap/img/touch.png">
    <style>
        header, footer, section, article, aside, nav, figure {
            display:block;
            margin:0;
            padding:0;
            border:0
        }
    </style>
    <link rel="shortcut icon" href="http://static.tieba.baidu.com/tb/favicon.ico">
    <link rel="canonical" href="http://tieba.baidu.com/p/2665938259">
    <link rel="stylesheet" href="short.css">
    <script>
        PDC.mark("ht");
        PDC.mark("vt");
    </script>
    <style id="ueditor_body_css">
        .edui-editor-body .edui-body-container p {
            margin:5px 0;
        }
        .edui-editor-body .edui-body-container {
            border:1px solid #ccc;
            border-left-color: #9a9a9a;
            border-top-color: #9a9a9a;
            outline:none;
            padding:0 10px 0;
            word-wrap:break-word;
            font-size:14px;
        }
        .edui-editor-body.focus {
            border:1px solid #5c9dff
        }
    </style>
</head>
<body class="skin_1" spellcheck="false">
    <div class="wrap1">
        <div class="wrap2">
            <div id="container" class="l_container clearfix ">
                <div class="p_thread thread_theme_3" id="thread_theme_3">
                    <div class="l_thread_info">
                        <ul class="l_posts_num">
                            <li class="l_pager pager_theme_2"></li>
                            <li class="l_reply_num" style="margin-left:2px; margin-right:10px">共有<span class="red"><?php $s=(int)(count($POSTLIST)/30+1); echo $s; ?></span>页</li>
                            <li class="l_reply_num"></li>
                            <li class="l_reply_num">回复贴:<span class="red" style="margin-right:3px"><?php echo count($POSTLIST);?>篇</span>
                            </li>
                        </ul>
                        <div class="l_thread_manage">
                            <div class="d_del_thread"><a class="j_thread_delete" href="?mod=threads&pn=<?php echo (int)($THREAD['seqnum']/50+1);?>">返回</a></div>
                            <div class="d_del_thread"><a class="j_thread_delete" href="#">删除主题</a>
                            </div>
                            <div id="d_post_manage" style="display: none;">
                                <a href="#" class="d_post_manage_link">贴子管理</a>
                                <ul id="j_quick_thread" class="quick_thread_theme2" style="display:none;">
                                    <li><a class="j_thread_setgood" href="#">设为精华贴</a>
                                    </li>
                                    <li><a class="j_thread_disgood" href="#">取消精华贴</a>
                                    </li>
                                    <li><a class="j_thread_settop" href="#">置顶主题</a>
                                    </li>
                                    <li><a class="j_thread_distop" href="#">取消置顶</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div id="tofrs_up" class="tofrs_up"></div>
                </div>
                <div class="left_section">
                    <div class="core">
                        <div class="core_title_wrap" id="j_core_title_wrap" style="">
                            <div class="core_title core_title_theme_2">
                                <a href="http://tieba.baidu.com/p/<?php echo c($THREAD['tid']);?>" target="__blank"><h1 class="core_title_txt" title="上交acm模板"><?php echo c($THREAD['title']);?></h1></a>
                                <ul class="core_title_btns">
                                    <li class="quick_reply"><a href="#" id="quick_reply" class="j_quick_reply" >回复</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="p_postlist" id="j_p_postlist">
                          <?php 
                          $i=0;
                          foreach($POSTLIST as $POST){

                            $POST['postcontent']=c($POST['postcontent']);                                  
                            $POST['floor']=++$i; 
                            if($i==1)
                              require "mainpost.php";
                            else require "post.php";
                          }
                          ?>
                        </div>
                        <div class="p_thread thread_theme_4" id="thread_theme_4">
                          <div class="l_thread_info">
                          <ul class="l_posts_num">
                            <li class="l_pager pager_theme_3"><span class="tP">1</span>
                            <?php
                              $page=1;
                              $num=(int)($THREAD['postnum']/30+1);
                              while($page<$num){
                                if($page!=$PN){
                              ?>
                              <a href="?mod=posts&tid=<?php echo $TID;?>&pn=<?php echo $page;?>"><?php echo $page;?></a>
                              <?php }else{ ?>
                              <span class="tP"><?php echo $PN;?></span> 
                              <?php }$page++;
                              }?>
                              <a href="?mod=posts&tid=<?php echo $TID;?>&pn=<?php echo $num;?>">尾页</a>
                            </li>
                            <li class="l_reply_num" style="margin-left:2px; margin-right:10px">共有<span class="red"><?php echo $num;?></span>页</li>
                            <li class="l_reply_num">跳到 <input theme="3" id="jumpPage3" max-page="<?php echo $num;?>" type="text" style="width:30px;height:14px;"> 
                            页&nbsp;<button id="pager_go3" type="button" value="确定" style="padding: 0 2px 0 2px;height:21px;line-height:15px;">确定</button>&nbsp;</li>
                            <li class="l_reply_num">回复贴:<span class="red" style="margin-right:3px"><?php echo $THREAD['postnum'];?></span></li>
                          </ul>
                            </div>
                          </div>
                      </div>
                  </div>

              <style>
                    .iframe{
                  -webkit-background-clip: border-box;
                  -webkit-background-origin: padding-box;
                  -webkit-background-size: auto;
                  -webkit-border-image: none;
                  -webkit-box-shadow: rgb(192, 192, 192) 10px 10px 10px 0px;
                  background-attachment: scroll;
                  background-clip: border-box;
                  background-color: rgb(255, 255, 255);
                  background-image: none;
                  background-origin: padding-box;
                  background-size: auto;
                  border-bottom-color: rgb(128, 128, 128);
                  border-bottom-left-radius: 26.65625px;
                  border-bottom-right-radius: 26.65625px;
                  border-bottom-style: solid;
                  border-bottom-width: 2px;
                  border-left-color: rgb(128, 128, 128);
                  border-left-style: solid;
                  border-left-width: 2px;
                  border-right-color: rgb(128, 128, 128);
                  border-right-style: solid;
                  border-right-width: 2px;
                  border-top-color: rgb(128, 128, 128);
                  border-top-left-radius: 26.65625px;
                  border-top-right-radius: 26.65625px;
                  border-top-style: solid;
                  border-top-width: 2px;
                  box-shadow: rgb(192, 192, 192) 10px 10px 10px 0px;
                  color: rgb(0, 0, 0);
                  display: block;
                  font-family: 'DejaVu Sans', 'Bitstream Vera Sans', 'Lucida Sans', 'Hiragino Sans GB', 'Microsoft YaHei', 'WenQuanYi Micro Hei', sans-serif;
                  font-size: 14px;
                  height: 755px;
                  margin-left: auto;
                  margin-right: auto;
                  margin-top: 30px;
                  padding-bottom: 32px;
                  /*padding-left: 64px;
                  padding-right: 64px;
                  */
                  padding-top: 32px;
                  text-align: justify;
                  }
              </style>
              <iframe class="iframe" src="http://tieba.baidu.com/p/<?php echo $TID;?>" 
                  style="width:980px;height:900px;background:#808080;"
              ></iframe>
              </div>
          </div>
    </div>
    <?php require "footer.php"; ?>
