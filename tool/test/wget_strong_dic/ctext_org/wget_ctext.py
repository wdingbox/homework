#!/usr/bin/python


import os, os.path
import sys, string
from types import *
import re
import time
from datetime import datetime , timedelta
import socket 
import urllib 



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


#http://ctext.org/pre-qin-and-han/zh?searchu=%E9%AC%BC&page=38
def wget_files(OutputFiles,  istart, iMax):
    for i in range(istart, 1+iMax, 1):
        url2 = "http://ctext.org/pre-qin-and-han/zh?searchu=%E9%AC%BC&page="
        url= url2+ str(i)
        
        fname=("000"+str(i))[-4:] + ".html"
        Outfile=DirTmp + "/" + fname
        OutputFiles.append(fname)
        cmd="wget "+url + " -O " + Outfile
        cmd="wget "+url + " >> out.html" 
        cmd="wget  -O " + Outfile + " " + url 
        print cmd
        if bWget=="y":
            os.system(cmd)
        time.sleep(10)
        
    print ('------------------------')
    
    
wget_files(OutputFiles,11, 106)

exit(0)


def rewrite_file(file, srcdir, subdir):
    srcfile=srcdir+"/"+file
    print srcfile
    if not os.path.exists(srcfile):
        print "... ERROR filenmae! stop!"
        return
    #time.sleep(0.2)
    sbody=""
    bWrte=0;
    for line in open(srcfile).readlines():
        #line=line.strip()

        #raw_input(line)
        if line.strip()=='<DIV ID=\"pMe\"><CENTER>':
            bWrte=1
            sbody+=(line)
            print line
            #raw_input( "start "+file)
            continue
        if line.strip()=='</CENTER></DIV>':
            
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
    
    file2=subdir+"/"+file[:-1]
    print file2
    
    if bWrite!="y":
        return

    pf2=open(file2,"w")
    pf2.write(MyHtm0)
    pf2.write(sbody)
    pf2.write(MyHtm9)
    pf2.close()
    

for file in OutputFiles:
    rewrite_file(file, DirTmp, DirTar)

    
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
   
    
    
    
    
    