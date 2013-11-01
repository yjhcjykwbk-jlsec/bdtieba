// JavaScript Document
function setstar(tid,star){
  $.ajax({ url:"http://localhost/tieba/ajax.php", data:"action=setstar&tid="+tid+"&star="+star, type:'post', dataType:'json', 
    success:function(result){ 
      console.log("set thread "+tid+" star "+star+" succeed"); 
      cookie.set(tid,star);
    },fail:function(result){
      console.log(result);
    }});
}
var stars=function(e,id){
  this.e=e;
  this.id=id;
}
stars.prototype={
  lock:function(){
    $(this.e).onmousemove=null;
    $(this.e).onclick=null;
    $(this.e).onmouseout=null;
  },
  _get:function(event){
      console.log(event);
      console.log(event.pageX);
      console.log(this.e.offset());
      var _left=event.pageX-this.e.offset().left;
      console.log(_left);
      return _left/26;
  },
  unlock:function(){
    var _this=this;
    //sw.$(this.e).wid=this.id;
    this.e.bind("mouseover",function(){
      this.focus();
    })
    this.e.bind("mousemove",function(event){
    });
    this.e.bind("mouseout",function(){
      ///this.style.backgroundPosition='-130px';
      //this.star=0;
      //$('#m')[0].innerHTML='';
    });
    this.e.bind('click',function(event){
      console.log(_this);
      stars.prototype.lock();
      var _th = _this;
      var _e=this;
      _e.star=_this._get(event);
      console.log("http://localhost/tieba/ajax.php"+"?action=setstar&tid="+_th.id+"&star="+_e.star);
      setstar(_th.id,this.star);
      _th.setScore(this.star);
      console.log(_e.star);
    })
  },
  setScore:function(s){
    c=this.e.context;
    s=Math.round(s);
    t=(s-5)*26;
    console.log(s);
    c.style.backgroundPosition=t+'px';
    console.log(c.style.backgroundPosition);
    $('#m')[0].innerHTML='<strong>'+s+'</strong>'+'分';
  }
}

function hideThreads(){
    a=$('.thread_list').hidden();
}
