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



def rewrite_file(file1, file2):
    pf2=open(file2,"w")
    
    reg0=re.compile(ur"^[\@][_]([\d\w]{3})[\s]",re.UNICODE)
    reg1=re.compile(ur"(^[\d]{1,9})[\:]([\d]{1,9})[\s]",re.UNICODE)
    
    sba=""
    for line in open(file1).readlines():
        print line
        mat0=reg0.search(line)
        mat1=reg1.search(line)
        if mat0:
            sba=mat0.group(1)
            print sba
            
        if mat1:
            jk="S."+sba+mat1.group(1) + "_" + mat1.group(2)            
            nln=jk+"=\""+mat1.group(3)+"\";\r\n"
            print nln

            pf2.write(nln)
            #pf2.close()
    
 

rewrite_file("StudiumChinese2.txt","StudiumChinese.js")
print "ok"


exit(0)
   
   
   
   
   
   
   
   
   
   
   
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    