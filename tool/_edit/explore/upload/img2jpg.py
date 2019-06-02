#!/usr/bin/python
# -*- coding: utf-8 -*-

#import MySQLdb as mdb

import Image 

import sys, string
import os, os.path



#To avoid virous in images.
class ImageResave:
   ImgList=[".jpg", ".jpeg",".gif",".img", ".png"]
   m_idx=0
   def walk_recursively(self,workdir):     
      #dirs = sorted(os.listdir( workdir ))
      for file in os.listdir( workdir ):    
        pathfile = os.path.join(workdir, file)
        if os.path.isdir(pathfile):
            self.walk_recursively(pathfile)
            continue
        self.img2jpg(pathfile)

   def walk_dir(self,workdir):     
      #dirs = sorted(os.listdir( workdir ))
      for file in os.listdir( workdir ):    
        pathfile = os.path.join(workdir, file)
        self.img2jpg(pathfile)
               
   def img2jpg(self, pathfile):        
        ##print pathfile
        fileName, fileExtension = os.path.splitext(pathfile)    
        fileExtension = fileExtension.lower()
        if not fileExtension in self.ImgList:
           return
        file0size = os.path.getsize(pathfile)
        print  fileName + fileExtension , file0size
        fileName2 = fileName + ".jpg"        
        
        try:
           im = Image.open(pathfile)        
           if im.mode != "RGB":
                im = im.convert("RGB")
           im.save(fileName2, "JPEG") 
           file2size=os.path.getsize(fileName2)
           print  fileName2, file2size
           dltsize = int(file0size) - int(file2size)
           if fileExtension != ".jpg":
                os.remove(pathfile) 
                print self.m_idx, " --- img type and size are changed:", dltsize
           else:print self.m_idx, " ... size changed:", dltsize
           self.m_idx +=1
           print ""
        except ValueError:
           print "[error convert]", pathfile
              
   def usage(self):
        print "Usage1: \n   img2jpg -r imgDir \n   -r: recursively"
        print "Usage2: \n   img2jpg imgfilename"	

   def main(self):
      if len(sys.argv)==1:
        self.usage()
        return
      elif len(sys.argv)==2:
        imgTarget=sys.argv[1]
        if os.path.isdir(imgTarget):
            print "convert img file into jpg for: " + imgTarget
            self.walk_dir(imgTarget)
        elif os.path.isfile(imgTarget):
            self.img2jpg(imgTarget)
        else:
            print "not exist:" + imgTarget
            ##self.usage()
      elif len(sys.argv)==3 and "-r"==sys.argv[1]:
        self.walk_recursively(sys.argv[2])
      else: self.usage()

      
if "__main__" == __name__ :   
   #print sys.argv
   #print "getcwd=",os.getcwd()
   ir = ImageResave()
   ir.main()


    
