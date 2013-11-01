<?php
  require "db.php";
  $DB=new DB();
  $PN=isset($_ENV['pn'])?$_ENV['pn']:1;
  $NUM=isset($_ENV['num'])?$_ENV['num']:100;
  if(isset($_ENV['cid'])) $CID=$_ENV['cid'];
  require "postmanager.php";
  ?>
<html>
<head>
    <meta charset="utf-8">
    <title>个人论坛</title>
    <link rel="apple-touch-icon" href="http://tb2.bdstatic.com/tb/wap/img/touch.png">
    <style>
        header, footer, section, article, aside, nav, figure {
            display:block;
            margin:0;
            padding:0;http://localhost/www/tieba/?mod=posts&tid=2116338996
            border:0
        }
    </style>
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
        #a_stars {
        background: url("stars.png") no-repeat scroll -130px 0 transparent;
          opacity:0.7;
          cursor: pointer;
          display: inline;
          float: left;
          height: 20px;
          margin-left: 5px;
          position: relative;
          width: 125px;
        }
    </style>
    <link href="tieba.css" rel="stylesheet" type="text/css">
    <script src="jquery.js"></script>
    <script src="tieba.js"></script>
</head>

<body class="skin_8" spellcheck="false">
    <div class="wrap1">
        <div class="wrap2">
            <div id="container">
                <?php require "forumheader.php"; ?>
                <?php if(isset($CID)) require "jinpintab.php";?>
                <?php require "threadlist.php"; ?>
            </div>
            <?php require "poster.php";?>
        </div>
    </div>
    <script>
        $(function(){
            astars=$('div#a_stars');
            for(i=0;i<astars.length;i++){
              astar=astars[i];
              new stars($(astar), astar.className).unlock();
            }
        });
    </script>
    <?php require "footer.php";?>
