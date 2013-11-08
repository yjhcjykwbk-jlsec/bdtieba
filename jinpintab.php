<div id="frs_good_nav" class="frs_good_nav_main_bright">
    <div class="frs_good_nav_wrap"><span><strong>全部</strong></span>
    <?php
        foreach($JINPINLIST as $i=>$JINPIN){
        ?>
          <span><a href="?kword=<?php echo $DBNAME;?>&cid=<?php echo $i+1;?>&pn=1&num=<?php echo $NUM;?>"><?php echo c($JINPIN['jinpinname']); ?></a></span>
    <?php } ?>
    </div>
</div>
