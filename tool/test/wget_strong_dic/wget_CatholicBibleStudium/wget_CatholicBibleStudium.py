#!/usr/bin/python


import os, os.path
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

index_hgs_Htm="""<HTML>
<HEAD><TITLE>HGB</TITLE>
<meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
<META name="viewport" content="width=device-witdh, initial-scale=1, maximum-scale=1, user-scale=0"></META>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<LINK HREF="./_/index_hgs.css" REL=stylesheet TYPE=text/css>
<SCRIPT LANGUAGE="JavaScript" SRC="./_/index_hgs.js"></SCRIPT>
</HEAD>
<BODY>
"""
hgbibleHtm="""
<LINK HREF="../_/main.css" REL=stylesheet TYPE=text/css>
<SCRIPT LANGUAGE="JavaScript" SRC="../_/qtip.js"></SCRIPT>
</HEAD>
<BODY>
"""
MyHtm9="</BODY></HTML>"










OutputFiles=[]


# http://www.qbible.com/hebrew-old-testament/genesis/1.html
# http://www.qbible.com/hebrew-old-testament/genesis/2.html

# http://www.qbible.com/greek-new-testament/matthew/1.html
DirTarget="studium"
DirTmp="dwn_studium_orig"

os.system("mkdir "+DirTmp)
baseUrl="http://bible.kyhs.me/sigaoben/"
def wget_files(OutputFiles, surl, path, iMax, outDir):
    bDownload=raw_input("Download ? (y:yes)")
    
    hometable="<table border='1' class='hometable'>"
    hometable+="<tr><th>#</th><th>Name</th><th>chap</th></tr>"
    for indx in range(1,iMax+1): 
        bookidx=("00"+str(indx))[-3:]
        ufile=bookidx+".htm"
        url= surl+path+"/"+ufile
        #print url
        cmd="wget "+url +" -O " + outDir + "/" +path+ufile
        print cmd
        if bDownload=="y":
            os.system(cmd)

        time.sleep(0.1) 
        
    hometable+="</table>"
    return hometable
#wget_files(OutputFiles,"H", 8674)
#wget_files(OutputFiles,"G", 5624)

indxfile="index_Studium.htm"
xtm=wget_files(OutputFiles,baseUrl, "jiuyue", 50, DirTmp)
pindex=open(indxfile,"w")
pindex.write(index_hgs_Htm)
pindex.write(xtm)
pindex.write(MyHtm9)
pindex.close()
print indxfile




tot=0;

cmd ="rm -rf " + DirTarget
os.system(cmd)
cmd ="mkdir " + DirTarget
os.system(cmd)


def rewrite_file(file, srcDir, targetdir):
    file1=srcDir+"/"+file
    print "file1:",file1
    sbody=""
    bWrte=0;
    for line in open(file1).readlines():
        #line=line.strip()

        #raw_input(line)
        if line.strip()=='<DIV ID=\"pMe\">':
            bWrte=1
            sbody+=(line)
            print line
            #raw_input( "start "+file)
            continue
        if line.strip()=='</DIV>':
            
            if bWrte==1 :
                sbody+=(line)
                print line
                #raw_input("got exit.**********")
                break
            
            #raw_input("got first one.**********")
            continue
        
        if 1==bWrte:
            sbody+=(line)
            #print line
    mat=re.compile("([\d]{2})_([\d]{3})_([\w]{3})").search(file)
    stitle=mat.group(3)+"_"+mat.group(2)
    f2=mat.group(1)+"_"+stitle+".htm"
    file2=targetdir+"/"+f2   #"/"+file[:-1]
    print "file2",file2
    if "y"!=bRewrite:
        return
        
    goDir="s"
    
    sbody=re.sub(r"[\"]http[\:][\/][\/]lexiconcordance[\.]com[\/]hebrew[\/]([\d]{4})[\.]html[\"]", r'"../'+goDir+r'/h\1.htm"', sbody)
    stxt=re.sub(r"[\"]http[\:][\/][\/]lexiconcordance[\.]com[\/]greek[\/]([\d]{4})[\.]html[\"]", r'"../'+goDir+r'/g\1.htm"', sbody)
    
    #time.sleep(0.2)
    pf2=open(file2,"w")
    pf2.write("<HTML><HEAD>\r\n")
    pf2.write("<title>"+stitle+"</title>\r\n")
    pf2.write(hgbibleHtm)
    pf2.write(stxt)
    pf2.write(MyHtm9)
    pf2.close()
    
    
bRewrite=raw_input("Rewrite ? (y:yes)")
for file in OutputFiles:
    tot+=1  
    rewrite_file(file, DirTmp, DirTarget)
print "tot=",tot

zipfilename=DirTarget+"_zcvf.tar.gzip"

cmd="tar -zcvf "+zipfilename+ " "+DirTarget + " _ " + indxfile 
print cmd

Dest="../../../../../../___bigdata/___compact/___zcvf2xf/res/hgsbible"
os.system(cmd)
cmd="cp -vf "+zipfilename+" "+Dest+"/."
print cmd
os.system(cmd)


print "ok"


exit(0)
   
   
   
   
   
   
   
   
   
   
   
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    