<?php require_once "postmanager.php"; ?>
    <table class="l_post" width="100%" ><tr>
    <?php require "author.php"?>
    <td class="d_post_content_main">
        <div class="p_content">
            <cc>
                <div id="post_content_40704045971" class="d_post_content j_d_post_content">
                    <?php echo $POST['postcontent']; ?>
                </div>
            </cc>
            <br>
        </div>

        <div class="core_reply j_lzl_wrapper">
            <a class="l_post_anchor" name="40704045971l"></a>
            <div class="core_reply_tail">
                <div class="j_lzl_r p_reply" data-field="{&quot;pid&quot;:40704045971,&quot;total_num&quot;:2}"> <a href="#" class="lzl_link_unfold" style="display:none;">回复(2)</a>  <span class="lzl_link_fold" style="display:;">收起回复</span> 
                </div>
                <ul class="p_tail">
                    <li><span class=""><?php echo $POST['floor']; ?>楼</span>
                    </li>
                    <li><span><?php echo $POST['timestamp']; ?></span>
                    </li>
                  <li><span><a class="p_post_del" href="#">删除</a>&nbsp;</span></li>
                </ul>
            </div>
            <?php if(count($POST['lzl'])>0){?>
            <div class="j_lzl_container core_reply_wrapper" data-field="{&quot;pid&quot;:40704045971,&quot;floor_num&quot;:2}" style="display:">
                <div class="core_reply_border_top"></div>
                <div class="j_lzl_c_b_a core_reply_content">
                    <ul class="j_lzl_m_w" style="display:">
                        <?php foreach($POST['lzl'] as $LZL){?>
                        <li class="lzl_single_post j_lzl_s_p first_no_border">
                            <a class="l_post_anchor" name="$spid"></a>
                            <div class="j_user_card lzl_p_p" >
                              <img src="user<?php echo rand(0,16);?>.jpg" style="height:32px;width:32px;"/>
                            </div>
                            <div class="lzl_cnt"> <span class="lzl_content_main">  
                            <span>&nbsp;&nbsp;</span><?php echo htmlspecialchars(c($LZL['content'])); ?>
                          </span> 
                                <div class="lzl_content_reply"><span class="lzl_jb"></span><span class="lzl_op_list j_lzl_o_l" style=""><a href="#" class="j_lzl_ban">封</a>&nbsp;|&nbsp;<a href="#" class="j_lzl_del">删除</a>&nbsp;|&nbsp;</span><span class="lzl_time"><?php echo $LZL['timestamp']; ?></span>
                                    <a href="#" class="lzl_s_r">回复</a>
                                </div>
                            </div>
                        </li>
                        <?php } ?>
                        <li class="lzl_li_pager j_lzl_l_p lzl_li_pager_s" data-field="{&quot;total_num&quot;:2,&quot;total_page&quot;:1}">
                            <p class="j_lzl_p"><a href="##">我也说一句</a>
                            </p>
                        </li>
                    </ul>
                    <div class="lzl_editor_container j_lzl_e_c lzl_editor_container_s" style="display:none;"></div>
                    <input type="text" class="j_lzl_e_f_h" style="display:none;">
                </div>
                <div class="core_reply_border_bottom"></div>
            </div>
            <?php }?>
        </div>
    </td></tr></table>
