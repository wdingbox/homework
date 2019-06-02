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
class FindFiles_frqFnamesAry:
    m_fnamesAry=[]
    def main(self,sdir):
        for root, dirs, files in os.walk(sdir):
            #print "[root,dirs,files]",root, dirs,files
            for file in files:
                if file[-8:]=="_frq.txt":
                    #print "---",root,file
                    self.m_fnamesAry.append(root+"/"+file)
        print "frq file list:"
        for pathfile in self.m_fnamesAry:
            print pathfile
        print ""


class Word_Ary_Loader:
    wordpopsFilename="word_void.js"
    m_Ary=[]
    def __init__(self, fname):
        #fname=self.wordpopsFilename
        with open(fname, 'r') as f:
            for line in f.readlines():
                line=line.strip()
                if len(line)==0: continue
                line=line.replace("\"","").replace(",","")
                self.m_Ary.append(line.strip())
        for pop in self.m_Ary:
            #print "to pop:",pop
            continue


class Word_Dict_Loader:
    m_fname=""
    m_dict={}
    def __init__(self, fname):
        if len(fname)>0:
            wdict={} 
            with open(fname, 'r') as f:
                wroot=""
                for line in f.readlines():
                    mat=re.match(r'^[\"](.*)[\"][\:][\[]',line)
                    if mat:
                        wroot=mat.group(1)
                        #print "key:", wroot
                        wroot=wroot.strip()
                        wdict[wroot]=[]
                        continue
                    mat=re.match(r'^[\"](.*)[\"][\,]{0,1}',line)
                    if mat:
                        variation=mat.group(1)
                        #print "word variation:", variation
                        wdict[wroot].append(variation)
            self.m_dict=wdict
            self.m_fname=fname
        
    def save_as_js(self,  jsvarname):
        d=self.m_dict
        #sort by key:0 
        od = sorted(d.items(), key=lambda t: (t[1],t[0]), reverse=False)
        with open(self.m_fname,'w') as f:
            f.write("var "+jsvarname+"={\n")
            for key, ar in od: 
                f.write("\""+key+"\":[\n")
                for str in ar:
                    f.write("\""+str+"\",\n")
                f.write("],\n\n") 
            f.write("}\n")


class FrqTxtFiles_to_FrqWordJs:
    m_keyFrqDic={}  # for each segment.
    m_keyFrqSegLine=""
    desFile=open("out.js",'w+a')

    m_WordsAllDic={} #. overall segments. 
    def main(self):
        None

    def main_load_frq_file(self,sorted_frq_file,segId):
        fname="sam_sorted_frq.txt" # self.srcDir+self.srcFile
        
        self.m_keyFrqDic={}
        self.m_keyFrqSegLine=""

        keyFrqDic={}
        nextSegName=""
        startDataLoad=0
        with open(sorted_frq_file, 'r') as f:
            for line in f.readlines():
                line=line.strip()
                #line=line.replace("'","").replace("\"","")
                #line = re.sub(r'[\'\"]', '', line)
                line=line.strip()
                if len(line)<2: continue 
                #e.g. "NT":[
                mat=re.match(r'[\"](.*)[\"][\:]', line, 0)
                if mat:
                    segName=mat.group(1)
                    #print "sfileId:",segName
                    if 0==startDataLoad:
                        if 0==len(segId):
                            #print "===>segName:",segName
                            startDataLoad=1
                            self.m_keyFrqSegLine=line
                            continue
                        else:
                            if segId != segName:
                                continue
                            else:
                                #print "===>segName:",segName
                                startDataLoad=1
                                self.m_keyFrqSegLine=line
                                continue
                        print "start segName:",segName
                    else: # finished dataloading
                        nextSegName=segName
                        break
                    
                if 0==startDataLoad:continue
                #
                #print line, frq_work_ar[0:1], frq_work_ar[1:1]
                mat=re.match(r'(.*)[\s\t]+(.*)', line, 0)
                if(mat):
                    Frq=mat.group(1).replace("'","")
                    Key=mat.group(2)
                    Key = re.sub(r'[\"\']', '', Key)
                    Key=Key.strip()
                    if len(Key)==0 : continue
                    #if len(Key)<2: continue

                    #if Key is like "iiii", ignore that.

                    #print "group:", mat.group()
                    #print Frq, Key
                    #print "Key: mat.group(2)",Key
                    if Key in self.m_keyFrqDic:
                        self.m_keyFrqDic[Key]+=int(Frq)
                    else:
                        self.m_keyFrqDic[Key]=int(Frq)
        self.inital_clean_wordFrqDic()
        return nextSegName
    def inital_clean_wordFrqDic(self):
        words=self.m_keyFrqDic.keys()
        for word in words:
            word=word.strip()
            if len(word)<2: 
                self.m_keyFrqDic.pop(word)
                #print "******** popout :",word
                continue

            firstCha=word[0:1]
            bSameChaString=1
            for cha in list(word):
                if cha != firstCha:
                    bSameChaString=0
                    break
            if bSameChaString==1:
                print "******** popout Same Cha String:",word
                self.m_keyFrqDic.pop(word)  
                continue  
    def post_words_stats_write(self):
        d=self.m_WordsAllDic 
        od=sorted(d.items(), key=lambda x: (x[1],x[0]), reverse=True)
        proposalVaritionDic={}
        for key, frq in od: 
            mat=re.match(r'(.*)(es|s|ed|ing|ly|ful|ness)$', key, 0)
            if mat:
                wordroot=mat.group(1)
                if wordroot in self.m_WordsAllDic :
                    if wordroot not in proposalVaritionDic:
                        proposalVaritionDic[wordroot]=[]
                    proposalVaritionDic[wordroot].append(key) 
        ds=Word_Dict_Loader("")
        ds.m_fname="word_variation_proposed.js"
        ds.m_dict=proposalVaritionDic
        ds.save_as_js("word_variation_proposed")        


    def write_js_begin(self):
        self.desFile.write("var adjusted_frq_words_dict={\n") 
    def write_js_end(self):
        self.desFile.write("};\n") 

    def write_js_sorted_frq_dict(self):
        d=self.m_keyFrqDic
        #print "- - - ===== sort "
        #od = sorted(d.items(), key=lambda t: t[1], reverse=True)
        od=sorted(d.items(), key=lambda x: (x[1],x[0]), reverse=True)
        self.desFile.write(self.m_keyFrqSegLine+"\n")  

        for key, frq in od: 
            #print(frq, key) 
            self.desFile.write("["+str(frq)+",\""+key+"\"],\n")  

            ### for stats overall.
            if key in self.m_WordsAllDic:
                self.m_WordsAllDic[key]+=int(frq)
            else:
                self.m_WordsAllDic[key]=int(frq)

        self.desFile.write("],\n\n\n\n\n\n\n") 

    def write_sorted_dict_to_js_value_sort_only(self):
        d=self.m_keyFrqDic
        #print "- - - ===== sort "
        od = sorted(d.items(), key=lambda t: t[1], reverse=True)
        self.desFile.write(self.m_keyFrqSegLine+"\n")  
        for key, frq in od: 
            #print(frq, key) 
            self.desFile.write("["+str(frq)+",\""+key+"\"],\n")  
        self.desFile.write("],\n\n\n\n\n\n\n")     

class Worker:
    wordpopsAry         =Word_Ary_Loader("word_void.js")
    wordVariationDict   =Word_Dict_Loader("word_variation.js") 
    wordSynoymDict      =Word_Dict_Loader("word_synonym.js") 
    wordClassification  =Word_Dict_Loader("word_classification.js")
    wordVariation_Prop1_Dict  =Word_Dict_Loader("word_variation_proposed1.js")

    keyFrqDic     =FrqTxtFiles_to_FrqWordJs()

    plogfile=open("out.log","w")
    def main(self, filesAry):       
        self.keyFrqDic.write_js_begin()
        self.run(filesAry)
        self.keyFrqDic.write_js_end()
        self.keyFrqDic.post_words_stats_write()
    def run(self,filesAry):
        for fname in filesAry:
            #fname="sam_sorted_frq.txt"
            segId=""
            self.run_single_frq_file(fname,segId)
    def run_single_frq_file(self,fname, segId):
        print fname+", "+ segId
        self.plogfile.write("\n\n"+fname+", "+ segId)
        nextSeg=self.keyFrqDic.main_load_frq_file(fname,segId)
        self.run_wordfrq_merge()
        self.run_words_pop_out()
        self.keyFrqDic.write_js_sorted_frq_dict()
        if len(nextSeg)==0: return
        self.run_single_frq_file(fname,nextSeg)

        
    def run_words_pop_out(self):
        for k in self.wordpopsAry.m_Ary:
            #print k
            if( k in self.keyFrqDic.m_keyFrqDic.keys()):
                self.keyFrqDic.m_keyFrqDic.pop(k)
                self.plogfile.write("\npopout:"+k)

    def run_wordfrq_consolidation(self, adict):
        #replacer={"text":["as","a","xx"], "to":["it"]}
        for key in adict.keys():
            ar=adict[key]
            for reps in ar:
                reps=reps.strip()
                if(reps == key): continue
                frqKeys=self.keyFrqDic.m_keyFrqDic.keys()
                if reps in frqKeys: # must dynamically
                    if key not in frqKeys:
                        self.keyFrqDic.m_keyFrqDic[key]=0
                        self.plogfile.write( "--************************************ to add new node:"+key)
                    ifrq=int(self.keyFrqDic.m_keyFrqDic[reps])        
                    self.keyFrqDic.m_keyFrqDic[key]+=ifrq
                    self.keyFrqDic.m_keyFrqDic.pop(reps)
                    #print "merge variation", reps, self.keyFrqDic.m_keyFrqDic[reps]
                    #continue
                    self.plogfile.write("\nmerge variation:"+ key+ ","+reps+","+ str(ifrq))
 
    def run_wordfrq_merge(self):
        #replacer={"text":["as","a","xx"], "to":["it"]}
        # must be first.
        self.run_wordfrq_consolidation(self.wordVariation_Prop1_Dict.m_dict)
        self.run_wordfrq_consolidation(self.wordVariationDict.m_dict)
        self.run_wordfrq_consolidation(self.wordSynoymDict.m_dict)
        self.run_wordfrq_consolidation(self.wordClassification.m_dict)
        
        return




if "__main__" == __name__ : 
    srcDir="../../../../___bigdata/___compact/___incrementalRO/pub/sam_books/"
    ff=FindFiles_frqFnamesAry()
    ff.main(srcDir)

    w = Worker()

    srcFile="/bible/JesusWords_purer_sorted_frq.txt" #. sample.
    #ff.m_fnamesAry=[srcDir+srcFile] #. hijac for test.
    w.main(ff.m_fnamesAry)
    


    
    
    
    
    
    
    
    
    
    
    
    
    