#!/usr/bin/env python
# -*- coding: utf8 -*-
#
#
#
#
# 
# 
#
#
# wei.ding@emerson.com
sREVISON="rev:12/08/2011"


import pdb
import os, os.path  
import sys, string
#import filecmp #Appliance doesn't support this. 
import time #time
from datetime import datetime , timedelta
import re #regex
import socket 
import fnmatch

import collections 
import json

#
#from  chineseCharacter2PinYinLib import chineseCharacter2PinYinLib
class Find_TextFilesTobeFrq_Dict:
    m_fnamesDict={}
    def main(self,sdir):
        for root, dirs, files in os.walk(sdir):
            #print "[root,dirs,files]",root, dirs,files
            for file in files:
                mat=re.match(r'.*\_txt\_(.*)[\.]txt',file,0)
                if None==mat:
                    print "incorrect file name pattern:\n"+file
                    continue
                segname=mat.group(1)
                if("frq"==segname): continue
                ofname=root+"/"+file.replace(segname,"frq")

                pathfile=root+"/"+file
                self.m_fnamesDict[pathfile]={"outfile":ofname,"segname":segname}
        print "frq file list:"
        for pathfile in self.m_fnamesDict:
            print pathfile
            print self.m_fnamesDict[pathfile]["outfile"]
            print self.m_fnamesDict[pathfile]["segname"]
            print ""
        print ""


class Txt2Frq:
    m_keyFrqDic={}  # for each segment.

    def main(self,fnameDic):
        for fname in fnameDic:
            self.read_txt_file(fname)
            outfile=fnameDic[fname]["outfile"]
            segname=fnameDic[fname]["segname"]
            self.write_frq_word_file(outfile,segname)

    def read_txt_file(self,txtfile):
        self.m_txtFilename=txtfile 
        keyFrqDic={}
        with open(txtfile, 'r') as f:
            for line in f.readlines():
                line=line.lower()
                #line=line.replace("'","").replace("\"","")
                line = re.sub(r'[^a-z]', ' ', line)
                words=line.split(" ")
                for word in words:
                    word=word.strip()
                    if len(word)==0: continue
                    if word not in keyFrqDic:
                        keyFrqDic[word]=0
                    keyFrqDic[word]+=1  
        self.m_keyFrqDic=keyFrqDic
        self.m_txtFilename=txtfile 

    def write_frq_word_file(self,outfile,segname):
        print segname, "\n", outfile, "\n"
        f=open(outfile,"w")
        f.write("\""+segname+"\":[\n")
        d=self.m_keyFrqDic 
        od=sorted(d.items(), key=lambda x: (x[1],x[0]), reverse=True)
        for key, frq in od: 
            f.write(str(frq)+"  "+key+"\n")

        
         


if "__main__" == __name__ : 
    srcDir="../../../../___bigdata/___compact/___incrementalRO/pub/sam_books/"
    ff=Find_TextFilesTobeFrq_Dict()
    ff.main(srcDir)

    w = Txt2Frq()

    srcFile="/bible/JesusWords_purer_sorted_frq.txt" #. sample.
    srcFile="/engDictionary/5000_collegiate_vacaburary_txt_5kCDic.txt"
    #ff.m_fnamesAry=[srcDir+srcFile] #. hijac for test.
    w.main(ff.m_fnamesDict)
    


    
    
    
    
    
    
    
    
    
    
    
    
    