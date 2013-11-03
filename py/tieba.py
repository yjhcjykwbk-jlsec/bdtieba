#encoding=utf-8
import sys
reload(sys)
sys.setdefaultencoding( "utf-8" )
from bs4 import BeautifulSoup as bs
from pyquery import PyQuery as pyq
import urllib
import MySQLdb as sql
import json
import string
#fp=open('test2.html')
#soup=bs(fp)
#print soup.find_all("div class=\"p_content\"")


def myPrint(content):
  print type(content)
  print content
def myexec(sql):
  try:
    if cursor.execute(sql)!=1:
      print "[FAILED]"+sql
  except Exception ,err:
    print "[FAILED]",type(sql)
    print "[ERROR]",err
def myexec1(sql): 
  try:
    cursor.execute(sql)
  except Exception ,err:
    print "[FAILED]",type(sql)
    print "[ERROR]",err

class Tieba:
  def __init__(self):
    self.db="db"
  def insertPost(self,post_id, post_content,time):
    sql="insert into posts(postid,postcontent,timestamp) values ('%s','%s','%s')"%(post_id,post_content,time)
    #print "insert into posts(postid,postcontent,timestamp) values('%s, '%s','%s')"%(post_id,post_content[0:20],time)
    myexec(sql)
  def insertThread(self,thread_id,post_id,time):
    sql="insert into threads(tid,postid,timestamp) values ('%s','%s','%s')"%(thread_id,post_id,time)
    #print sql
    myexec(sql)
  def insertThreadDetails(self,thread_id,title,digest):
    sql="insert into thread_details(tid,title,digest,timestamp) values ('%s','%s','%s','%s')"%(thread_id,title,digest,'0')
    #print sql
    myexec(sql)
  def updateThreadTimestamp(self,thread_id,time):
    sql="update thread_details set timestamp='%s' where tid=%s"%(time,thread_id);
    #print sql
    myexec1(sql)
  def insertLzl(self,post_id,spid,content,time):
    sql="insert into lzls(postid,spid,content,timestamp) values(%s,%s,'%s','%s')"%(post_id,spid,content,time)
    #print "insert into lzls(postid,spid,content,timestamp) values(%s,%s,'%s','%s')"%(post_id,spid,content[0:20],time)
    myexec1(sql)
  def setJinpin(self,thread_id,jinpin_name):
    sql="update thread_details set jinpinname='%s' where tid=%s and timestamp=timestamp"%(jinpin_name,thread_id)
    myexec1(sql)
  def initJinpin(self,i,jinpin_name):
    sql="insert into jinpin(jinpinname,id) values('%s',%s)"%(jinpin_name,i)
    myexec1(sql)
  def updateJinpin(self,i,jinpin_name):
    sql="update jinpin set jinpinname='%s' where id=%s"%(jinpin_name,i)
    myexec1(sql)
  def clear(self):
    sql="delete from posts where 1=1"
    myexec1(sql);
    sql="delete from threads where 1=1"
    myexec1(sql);
    sql="delete from thread_details where 1=1"
    myexec1(sql);
    sql="delete from lzls where 1=1"
    myexec1(sql);
def saveFile(html,filename):
  file=open(filename,'w')
  file.write(html)
  file.flush();
  file.close();

#""把字符串全角转半角"""
def strQ2B(ustring):
  ustring=ustring.decode("cp936")
  rstring=""
  for uchar in ustring:
    inside_code=ord(uchar)
    print inside_code
    if inside_code==0x3000:
      inside_code=0x0020
    else:
      inside_code-=0xfee0
    if inside_code<0x0020 or inside_code>0x7e:
      rstring+=uchar.encode('cp936')
    else:
      rstring+=(unichr(inside_code)).encode('cp936')
  return rstring
def myEncode(text):
  try:
    #text=strQ2B(text)
    text=text.decode("utf-8").encode("gbk");
    text=text.replace("'","\\'");
  except Exception, err:
    print "[FAILED]myEncode:",type(text)
    print "[ERROR]",err
    return ""
  return text


import sys
dbname=sys.argv[1]
#initialize global variables  
# database
db = sql.connect("127.0.0.1","root","",dbname)
# prepare a cursor object using cursor() method
cursor = db.cursor()
tieba=Tieba()
#clear all database of this tieba
#tieba.clear();

def myOpen(url):
  import urllib,urllib2,cookielib
  proxy_support=urllib2.ProxyHandler({'http':'http://I303035:Stevenberge123@proxy:8083'})
  #opener = urllib2.build_opener(urllib2.HTTPCookieProcessor(cookielib.LWPCookieJar()))
  opener = urllib2.build_opener(proxy_support, urllib2.HTTPHandler)
  html=opener.open(url).read()
  return html
  #saveFile(html,'temp.html')
 
def getPager1(doc):#doc is a pyquery obj
  return doc('li.l_pager')('.pager_theme_2') 

def getPager2(doc):
  return doc('.pager')('.clearfix')

def getNextPage(o_url,page):
  if o_url.find('?'):
    url=o_url+"&pn="+"%s"%(page)
  else:
    url=o_url+"?pn="+"%s"%(page)
  return url

def handlePages(url,page,getPager,func,parameters):
  #html=fp.read();#gbk 
  #html=myOpen(url)
  html=pyq(url);
  doc=pyq(html)
  #handlePostPage(doc)
  func(doc,parameters);
  l_pager=getPager(doc);
  #print l_pager
  if l_pager:
    #cur_page=pyq(l_pager)('.tP') #<span class="tP">2</span>
    #cur_page=string.atoi(cur_page.text())
    #cur_page=page
    for page_num in l_pager.children():
      href_text=pyq(page_num).text()
      if href_text=="%s"%(page+1):
        url="http://tieba.baidu.com"+pyq(page_num).attr('href')
        print "handling next page:"+url;
        handlePages(url,page+1,getPager,func,parameters) #下一页
        break
            
#handle with the main page 
def handleMainPage(doc,parameters):
    threadlist_lis=doc('.threadlist_li_right')
    for threadlist_li in threadlist_lis:
      #上边 title href
      threadlist_text=pyq(threadlist_li)('.threadlist_title')
      j_th_tit=pyq(threadlist_text)('a')
      title=myEncode(j_th_tit.text())
      href=pyq(j_th_tit).attr('href')
      if href[0]!='/':#not a thread, such as href='/p/xxx'
        continue
      thread_id=href.split('/')[2]
      #下边 摘要
      threadlist_abs=pyq(threadlist_li)('.threadlist_detail')('.threadlist_text').children().children()
      digest=myEncode(threadlist_abs.text())
      print "title:"+title
      print "thread_id:"+thread_id
      print "digest:"+digest
      tieba.insertThreadDetails(thread_id,title,digest)
      parameters['thread_id']=thread_id
      #handle with each thread 
      #you can kick this if you just want to crawl thread details
      handlePages('http://tieba.baidu.com/p/'+thread_id,1,getPager1,handlePostPage,parameters)

#handle with the posts page
def handlePostPage(doc,parameters):
  thread_id=parameters['thread_id']
  print "handling thread:"+thread_id
  l_posts=doc('.l_post')
  #d_post_content_mains=doc('.d_post_content_main')
  for i,l_post in enumerate(l_posts):
    datas=(pyq(l_post)).attr('data-field')
    datas=json.loads(datas)
    time=myEncode(datas['content']['date'])
    #for each post in this page
    d_post_content=(pyq(l_post))('.d_post_content')
    post_content_id=pyq(d_post_content).attr('id')
    ri=post_content_id.rfind("_")
    post_id=post_content_id.split('_')[2]
    post_content=pyq(d_post_content).html()
    #if is the last post
    if i==len(l_posts)-1:
      #print "update thread:"+thread_id+" timestamp:"+time+" post:"+post_id
      tieba.updateThreadTimestamp(thread_id,time)
    print "handling post:"+post_id 
    tieba.insertThread(thread_id,post_id,time)
    post_content=myEncode(post_content)
    #post_content=repr(post_content);
    tieba.insertPost(post_id,post_content,time)
    #handle with lzl( lou zhong lou )
    lzls=(pyq(l_post))('li.lzl_single_post')
    if lzls:
      for lzl in lzls:
        data_field=pyq(lzl).attr('data-field');
        if data_field==None:
          break
        lzl_data=(json.loads(data_field))
        spid=myEncode(lzl_data['spid'])
        if spid==None:
          break;
        print "handling lzl:"+spid
        lzl_cnt=myEncode(pyq(lzl)('.lzl_content_main').text())
        lzl_time=pyq(lzl)('.lzl_time').text()
        tieba.insertLzl(post_id,spid,lzl_cnt,lzl_time)
        
#处理精品帖子功能的入口
def handleJinpinPages(url):
    print url
    doc=pyq(url)
    jinpin_list=doc('.frs_good_nav_main_bright')
    print jinpin_list
    jinpins=pyq(jinpin_list)('span')
    for i,jinpin in enumerate(jinpins):
        href=pyq(jinpin)('a').attr('href')
        jinpin=myEncode(pyq(jinpin).text())
        print i
        print jinpin
        print href
        if i!=0: #略过'全部'
            tieba.initJinpin(i,jinpin)
            parameters={}
            parameters['text']=jinpin
            handlePages("http://tieba.baidu.com"+href,1,getPager2,handleJinpinPage,parameters)

#解析精品帖子页面
def handleJinpinPage(doc,parameters):
    print parameters
    jinpin_name=parameters['text']
    threadlist_lis=doc('.threadlist_li_right')
    for threadlist_li in threadlist_lis:
      #上边 title href
      threadlist_text=pyq(threadlist_li)('.threadlist_title')
      j_th_tit=pyq(threadlist_text)('a')
      title=myEncode(j_th_tit.text())
      href=pyq(j_th_tit).attr('href')
      if href[0]!='/':#not a thread, such as href='/p/xxx'
        continue
      thread_id=href.split('/')[2]
      #print "thread_id:"+thread_id
      print "thread_title:"+title
      #print jinpin_name
      tieba.setJinpin(thread_id,jinpin_name)
     



###################################################

#test:
#parameters['thread_id']='2072174673'
#handlePages("http://tieba.baidu.com/p/2072174673",1,getPager1,handlePostPage,parameters)

print "usage: python tieba.py dbname(mydb for example) tiebaname('仙剑' for example)"
#use this to bake a tieba
tieba_name=sys.argv[2]
#crawl the tieba posts and threads
parameters={}
handlePages("http://tieba.baidu.com/f?tp=0&kw="+tieba_name,1,getPager2,handleMainPage,parameters)
#handle with jingpin
handleJinpinPages('http://tieba.baidu.com/f/good?kw='+tieba_name)

#post_content=sql.escape_string(str(post_content))
#print sql.escape_string(str)
