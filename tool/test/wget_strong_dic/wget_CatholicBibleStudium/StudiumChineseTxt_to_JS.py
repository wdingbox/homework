#!/usr/bin/python
# -*- coding: utf-8 -*-

import os, os.path
import sys, string
from types import *
import re
import time
from datetime import datetime , timedelta
import socket 
import urllib 
import glob
import operator


def GetFirstKeyForEachFileInDir(sDirRef):
    ret={}
    reg0=re.compile("^[\w][\.]([_][\d\w]{3}[\d]+[_][\d]+)")
    os.system("mkdir _"+sDirRef)
    filter = sDirRef+"/*.js"
    print filter
    for file in sorted(glob.glob(filter)):
        print file
        for line in open(file).readlines():
            line1=line.decode('utf-8')
            line = line.strip()
            mat = reg0.search(line)
            if mat:
                ret[mat.group(1)]="_"+file
                print file, mat.group(1)
                break                
    return ret
    
#rewrite original txt file into js.
def plainTxt2jsfile(txtfile, jsfile):
    pf2=open(jsfile,"w")
    
    reg0=re.compile(ur"^[\@][_]([\d\w]{3})[\s]",re.UNICODE)
    reg1=re.compile("^([\d]{1,9})[\:]([\d]{1,9})[\s]([^\r\n]+)")
    
    sba=""
    for line in open(txtfile).readlines():
        #print line
        line1=line.decode('utf-8')
        #print line1
        mat0=reg0.search(line)
        mat1=reg1.search(line)
        if mat0:
            sba=mat0.group(1)
            print sba
            
        if mat1:
            jskey="_"+sba+mat1.group(1) + "_" + mat1.group(2)  
            jk="S."+ jskey         
            nln=jk+"=\""+mat1.group(3)+"\";\r\n"
            print (nln)
            pf2.write(nln)
    pf2.close()
    
def split_file_by_jskeyArr(jsfile, splitFileNameArr):
    pf2=None
    reg0=re.compile(ur"^[\w][\.]([_][\d\w]{3}[\d]+[_][\d]+)",re.UNICODE)
    for line in open(jsfile).readlines():
        
        mat0=reg0.search(line)
        if mat0:
            jskey=mat0.group(1)
            #print jskey
            
            if jskey in splitFileNameArr:
                fname=splitFileNameArr[jskey]
                print "file="+fname
                if pf2:
                    pf2.close()
                pf2=open( fname,"w")
            pf2.write(line)
            
    pf2.close()   
def split_file_by_jsdir(jsfile, jsdir):
    splitFileNameArr = GetFirstKeyForEachFileInDir(jsdir)
    split_file_by_jskeyArr(jsfile, splitFileNameArr)     

    
jsdir=sys.argv[1] 
if not os.path.exists(jsdir):
    print "missing jsdir"
    exit(0)
    
retArr=GetFirstKeyForEachFileInDir(jsdir)
print retArr



    
jsFileName="StudiumChinese.js"
if raw_input("output: "+jsFileName+"?(y:yes)")=="y":
    plainTxt2jsfile("StudiumChinese2.txt",jsFileName)
print "js ok"

raw_input()

split_file_by_jskeyArr(jsFileName, retArr)

exit(0)
   
   
   
   
   
   
   
   
   
   
   
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    