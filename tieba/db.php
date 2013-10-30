<?php
/////datatype
class DB{
    var $Host="127.0.0.1:3306";
    var $Database="tieba";
    var $User="root";
    var $Pwd="";
    var $Link_ID=0;//
    var $Query_ID=0;
    var $Fields_Array;//缓存返回集合的各列名字
    var $Rows_Array;//缓存返回集合的各行
    function connect($Database="",$Host="",$User="",$Pwd=""){
        if($Database=="") $Database=$this->Database;
        if($Host=="") $Host=$this->Host;
        if($User=="") $User=$this->User;
        if($Pwd=="")  $Pwd=$this->Pwd;
        if($this->Link_ID==0){
            $this->Link_ID=@mysql_pconnect($Host,$User,$Pwd);
            if(!$this->Link_ID){
                $this->halt("connect mysql failed");
						}
            if(!mysql_select_db($this->Database,$this->Link_ID))
						{
                $this->halt("use database error");
						}
        }
        //$this->query("SET NAMES gbk");
        return $this->Link_ID;
    }function __construct(){
        $this->connect();
    }function __destruct(){
        mysql_close($this->Link_ID);
    }function query($query){
        if(!$this->Query_ID)
            $this->free();
        if(!$this->Link_ID) 
            $this->connect();
        $this->Query_ID=mysql_query($query,$this->Link_ID);
        if(!$this->Query_ID)
            $this->halt("sql query failed");
        return $this->Query_ID;
    }function get_rows(){
        return mysql_num_rows($this->Query_ID);
    }function get_rows_array(){
        $rows=mysql_num_rows($this->Query_ID);
        $this->Row_Array=array();
        for($i=0;$i<$rows;$i++){
            if(!mysql_data_seek($this->Query_ID,$i))
                $this->halt("mysql_data_seek failed at row".$i);
			else $this->Row_Array[$i]=mysql_fetch_array($this->Query_ID,MYSQL_ASSOC);
        }
        return $this->Row_Array;
    }function get_fields(){
        return mysql_num_fields($this->Query_ID);
    }function get_fields_array(){//返回结果中的各列名
        $fields=mysql_num_fields($this->Query_ID);
        for($i=0;$i<$fields;$i++)
            $this->Fields_Array[$i]=mysql_fetch_fields($this->Query_ID,$i)->name;
        return $this->Fields_Array;
    }function halt($msg){
        $error=mysql_error();
        printf("<BR><b>database has error</b>%s<br>\n",$msg);
        printf("<BR><b>mysql return error msg</b>%s<br>\n",$error);		
    }function free(){
        if($this->Query_ID){
            @mysql_free_result($this->Query_ID);
            $this->Query_ID=0;
        }
    }function get($sql){
      $this->query($sql);
      return $this->get_rows_array();
    }
}
?>
