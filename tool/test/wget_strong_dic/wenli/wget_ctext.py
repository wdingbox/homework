#!/usr/bin/python


import os, os.path
import glob
import sys, string
from types import *
import re
import time
from datetime import datetime , timedelta
import socket 
import urllib 

BookChaperMax={
  1:[ "/genesis/"           ,50  ,    "_Gen"  ],
  2:[ "/exodus/"            ,40  ,    "_Exo"  ],
  3:[ "/leviticus/"         ,27  ,    "_Lev"  ],
  4:[ "/numbers/"           ,36  ,    "_Num"  ],
  5:[ "/deuteronomy/"       ,34  ,    "_Deu"  ],
  6:[ "/joshua/"            ,24  ,    "_Jos"  ],
  7:[ "/judges/"            ,21  ,    "_Jug"  ],
  8:[ "/ruth/"              ,4   ,    "_Rut"  ],
  9:[ "/1-samuel/"          ,31  ,    "_1Sa"  ],
 10:[ "/2-samuel/"          ,24  ,    "_2Sa"  ],
 11:[ "/1-kings/"           ,22  ,    "_1Ki"  ],
 12:[ "/2-kings/"           ,25  ,    "_2Ki"  ],
 13:[ "/1-chronicles/"      ,29  ,    "_1Ch"  ],
 14:[ "/2-chronicles/"      ,36  ,    "_2Ch"  ],
 15:[ "/ezra/"              ,10  ,    "_Ezr"  ],
 16:[ "/nehemiah/"          ,13  ,    "_Neh"  ],
 17:[ "/esther/"            ,10  ,    "_Est"  ],
 18:[ "/job/"               ,42  ,    "_Job"  ],
 19:[ "/psalms/"            ,150 ,    "_Psm"  ],
 20:[ "/proverbs/"          ,31  ,    "_Pro"  ],
 21:[ "/ecclesiastes/"      ,12  ,    "_Ecc"  ],
 22:[ "/song-of-songs/"     ,8   ,    "_Son"  ],
 23:[ "/isaiah/"            ,66  ,    "_Isa"  ],
 24:[ "/jeremiah/"          ,52  ,    "_Jer"  ],
 25:[ "/lamentations/"      ,5   ,    "_Lam"  ],
 26:[ "/ezekiel/"           ,48  ,    "_Eze"  ],
 27:[ "/daniel/"            ,12  ,    "_Dan"  ],
 28:[ "/hosea/"             ,14  ,    "_Hos"  ],
 29:[ "/joel/"              ,3   ,    "_Joe"  ],
 30:[ "/amos/"              ,9   ,    "_Amo"  ],
 31:[ "/obadiah/"           ,1   ,    "_Oba"  ],
 32:[ "/jonah/"             ,4   ,    "_Jon"  ],
 33:[ "/micah/"             ,7   ,    "_Mic"  ],
 34:[ "/nahum/"             ,3   ,    "_Nah"  ],
 35:[ "/habakkuk/"          ,3   ,    "_Hab"  ],
 36:[ "/zephaniah/"         ,3   ,    "_Zep"  ],
 37:[ "/haggai/"            ,2   ,    "_Hag"  ],
 38:[ "/zechariah/"         ,14  ,    "_Zec"  ],
 39:[ "/malachi/"           ,4   ,    "_Mal"  ],
 40:[ "/matthew/"           ,28  ,    "_Mat"  ],
 41:[ "/mark/"              ,16  ,    "_Mak"  ],
 42:[ "/luke/"              ,24  ,    "_Luk"  ],
 43:[ "/john/"              ,21  ,    "_Jhn"  ],
 44:[ "/acts/"              ,28  ,    "_Act"  ],
 45:[ "/romans/"            ,16  ,    "_Rom"  ],
 46:[ "/1-corinthians/"     ,16  ,    "_1Co"  ],
 47:[ "/2-corinthians/"     ,13  ,    "_2Co"  ],
 48:[ "/galatians/"         ,6   ,    "_Gal"  ],
 49:[ "/ephesians/"         ,6   ,    "_Eph"  ],
 50:[ "/philippians/"       ,4   ,    "_Phl"  ],
 51:[ "/colossians/"        ,4   ,    "_Col"  ],
 52:[ "/1-thessalonians/"   ,5   ,    "_1Ts"  ],
 53:[ "/2-thessalonians/"   ,3   ,    "_2Ts"  ],
 54:[ "/1-timothy/"         ,6   ,    "_1Ti"  ],
 55:[ "/2-timothy/"         ,4   ,    "_2Ti"  ],
 56:[ "/titus/"             ,3   ,    "_Tit"  ],
 57:[ "/philemon/"          ,1   ,    "_Phm"  ],
 58:[ "/hebrews/"           ,13  ,    "_Heb"  ],
 59:[ "/james/"             ,5   ,    "_Jas"  ],
 60:[ "/1-peter/"           ,5   ,    "_1Pe"  ],
 61:[ "/2-peter/"           ,3   ,    "_2Pe"  ],
 62:[ "/1-john/"            ,5   ,    "_1Jn"  ],
 63:[ "/2-john/"            ,1   ,    "_2Jn"  ],
 64:[ "/3-john/"            ,1   ,    "_3Jn"  ],
 65:[ "/jude/"              ,1   ,    "_Jud"  ],
 66:[ "/revelation/"        ,22  ,    "_Rev"  ],
} 






MyHtm0="""<HTML>
<HEAD><TITLE></TITLE>
<LINK HREF="../_/main.css" REL=stylesheet TYPE=text/css>
<SCRIPT LANGUAGE="JavaScript" SRC="../_/qtip.js"></SCRIPT>
</HEAD>
<BODY>
"""
MyHtm9="</BODY></HTML>"




bWget=raw_input("bWget= (y:yes)")
bWrite=raw_input("bWrite= (y:yes)")

DirTmp="./dwn"
os.system("mkdir -v "+DirTmp)
DirTar="target"
os.system("mkdir -v "+DirTar)   
 
OutputFiles=[]

#site is http://www.godcom.net/wl/66.htm
def wget_files(OutputFiles,  istart, iMax):
    url2 = "http://www.godcom.net/wl/"

    for i in range(istart, 1+iMax, 1):
        strnm="000"+str(i)
        strnm=strnm[-2:]
        
        fname=strnm+ ".htm"
        url= url2+ strnm+".htm"
        Outfile=DirTmp + "/" + fname
        OutputFiles.append(fname)
        cmd="wget "+url + " -O " + Outfile 

        cmd="wget "+url + " >> out.html" 
        cmd="wget  -O " + Outfile + " " + url 

        cmd="curl "+url + " -o " + Outfile
        print cmd
        if bWget=="y":
            os.system(cmd)
        time.sleep(0)
        
    print ('------------------------')
    
    
wget_files(OutputFiles,1, 66)
#exit(0)






#pattern sample
#<p><span style="color:#ff0000;" id="1:1"><sup>1</sup></span>...</p>
#<p><span style="color:#ff0000;" id="1:2"><sup>2</sup></span>...</p>
BibleBook={}

def rewrite_file(file, srcdir, subdir):
    srcfile=srcdir+"/"+file
    print srcfile
    if not os.path.exists(srcfile):
        print "... ERROR filenmae! stop!"
        return
    #time.sleep(0.2)
    snum=file[:2]
    isum = int(snum)
    bookid=BookChaperMax[isum][2]
    print bookid

    sbody=""
    bWrte=0;
    for line in open(srcfile).readlines():
        #line=line.strip()
        #matchObj = re.match( r'\<p\>\<span style\=\"color:\#ff0000\;\" id\=\"([0-9])\:1\"\>\<sup\>1\<\/sup\>\<\/span\>(*)\<\/p\>', line)
        matchObj = re.match( r'(.*)([0-9]+):([0-9]+)', line)
        matchObj = re.match( r'(.*)id=[\"]([0-9]+):([0-9]+)\"\>\<sup\>(.*)\<\/sup\>\<\/span\>(.*)\<\/p\>',line)
        if matchObj:
            print "match", matchObj.group()
            print matchObj.group(1)
            print "chapNum", matchObj.group(2)
            print "versNum", matchObj.group(3)
            print matchObj.group(4)
            print matchObj.group(5)
            bookChpVers=bookid+matchObj.group(2)+"_"+matchObj.group(3)
            jstrn=bookChpVers+"='"+matchObj.group(5)+"';<br/>"
            print jstrn
            sbody += jstrn
            BibleBook[bookChpVers]=matchObj.group(5)
    return sbody

    

def rewrite_into_sigle_file():
    sbody=""
    for file in OutputFiles:
        sbody+=rewrite_file(file, DirTmp, DirTar)
    pf2=open("wl.htm","w")
    pf2.write(MyHtm0)
    pf2.write(sbody)
    pf2.write(MyHtm9)
    pf2.close()



#manully copy into utf8 file. wl.utf8.htm
rewrite_into_sigle_file()






class follow_existing_jsfile_to_write:
    BibleBook={}
    def load_single_file_into_dict(self,filename):
        for line in open(filename).readlines():
            mat=re.match(r'([\_][A-Z0-9][a-zA-Z]{2}[0-9]+[\_][0-9]+)[\=](.*)',line)
            if mat:
                bookchpverID=mat.group(1)
                self.BibleBook[bookchpverID]=mat.group(2)

        print self.BibleBook


    def get_key_of_file(self,file):
        body=""
        for line in open(file).readlines():
            #print line
            mat=re.match(r'[A-W][\.]([\_][A-Z0-9][a-zA-Z]{2}[0-9]+[\_][0-9]+)[\=](.*)',line)
            if mat:
                print "mat", mat.group()
                bookchpverID=mat.group(1)
                print "bookchpverID:",bookchpverID
                if self.BibleBook.has_key(bookchpverID):
                    print "wl:",self.BibleBook[bookchpverID]
                else:
                    self.BibleBook[bookchpverID]="(null)"
                body+="W."+bookchpverID+"="+self.BibleBook[bookchpverID]+"\n"
        return body

    def follow_existing_jsfile(self,srcdir,targetDir):
        for pathfile in glob.glob(srcdir):
        #for file in os.listdir(dir):
            print pathfile
            basefile=os.path.basename(pathfile)
            sbody=self.get_key_of_file(pathfile)
            file2=targetDir+"/"+basefile
            pf2=open(file2,"w")
            pf2.write(sbody)
            pf2.close()



fw=follow_existing_jsfile_to_write()
fw.load_single_file_into_dict("wl.utf8.htm")
fw.follow_existing_jsfile("../../../../../../___bigdata/unzipped/rel/ham12/jsdb/bible/cuvs/*.js", DirTar)    
exit(0)



print "\r\n"
zipfile=DirTar+"_zcvf.tar.gzip"    
cmd="tar -zcvf "+zipfile+" " + DirTar
print cmd
os.system(cmd)


Dest="../../../../../../___bigdata/___compact/___zcvf2xf/res/hgsbible"
cmd="cp -f "+zipfile+" " + Dest
print cmd
os.system(cmd)

exit(0)
   
    
    
    
    
    