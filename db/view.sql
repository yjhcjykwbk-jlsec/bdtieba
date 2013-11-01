“辅助对帖子进行排序
create view threadseq as select * from thread_details order by timestamp asc;
”对主题找到它的最后编辑时间
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `temp` AS select `threads`.`tid` AS `tid`,max(`threads`.`timestamp`) AS `time` from `threads` group by `threads`.`tid`;

//更新所有主题最后编辑时间：
// create view temp as select tid,max(threads.timestamp) as time from threads group by tid  ;
// update thread_details,temp set thread_details.timestamp=temp.time where thread_details.tid=temp.tid  ;
