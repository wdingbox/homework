#!/usr/bin/python

import os, os.path
import sys, string
from types import *
import re
import time
from datetime import datetime , timedelta
import socket 
import urllib 

import subprocess
from collections import OrderedDict

import json
from pprint import pprint
class Ip2Geo:
    IpGeo={}
    def __init__(self):
        jsonfilename='IpGeo.json'
        self.ip2geo_read(jsonfilename)
        self.ip2geo_sort_write(jsonfilename)
    def ip2geo_read(self,jsonfilename):       
        with open(jsonfilename) as data_file:    
            self.IpGeo = json.load(data_file)
            data_file.close()
        pprint(self.IpGeo)
    def ip2geo_sort_write(self, jsonfilename):
        ss="{\r\n"
        for ip in sorted(self.IpGeo):
            Geo=self.IpGeo[ip]
            ss=ss+"\""+ip.strip()+"\"   :     \""+Geo+"\",\r\n"
        ss=ss+"\"-\":\"-\""
        ss=ss+"}\r\n"
        pf=open(jsonfilename,'w')
        pf.write(ss)
        pf.close()
    def get_country(self,ip):
        for key in self.IpGeo.keys(): 
            if key.strip()==ip.strip():
                return self.IpGeo[key]
        return "-"    
    def ip2geo_dict(self):
        ss="<hr>{<br>"
        for ip in sorted(self.IpGeo):
            Geo=self.IpGeo[ip]
            ss=ss+"\""+ip.strip()+"\"  &nbsp; : &nbsp; &nbsp; &nbsp;  \""+Geo+"\",<br>\r\n"
        ss=ss+"\"-\":\"-\""
        return ss+"}<br><hr>"
ip2geo=Ip2Geo()

class auth_log_tmp:
    ipc={}
    def __init__(self):
        self.mv2tmp()
        self.run()
    def mv2tmp(self):
        srcdir="/var/log/apache2/"
        for file in os.listdir(srcdir):
            #print file
            mat=re.compile("access\.log\.[\d]+\.gz").search(file)
            if mat:
                gzsrc=srcdir+file
                gztar="/tmp/"+file
                cmd="cp "+gzsrc+" "+gztar
                os.system(cmd)
                print cmd
                cmd="gunzip -f "+gztar
                print cmd
                os.system(cmd)
                continue
            mat=re.compile("access\.log(\.[\d]+){0,}").search(file)
            if mat:
                gzsrc=srcdir+file
                gztar="/tmp/"+file
                cmd="cp -f "+gzsrc+" "+gztar
                os.system(cmd)
                print cmd
                continue
    def getfilelist(self):
        srcdir="/tmp/"
        filelist=[]
        for file in os.listdir(srcdir):
            #print file
            mat=re.compile("access[\.]log([\.][\d]+){0,}").search(file)
            if mat:
                filelist.append(srcdir+file)
                #self.search_ip(srcdir+file)
        #print filelist
        return filelist
    def search_ip(self, pathfile):
        if not os.path.exists(pathfile):
            return

        for line in open(pathfile):
            for ip in re.findall( r'[0-9]+(?:\.[0-9]+){3}', line ):
                if not ip in self.ipc.keys():
                    self.ipc[ip]=0
                self.ipc[ip]=self.ipc[ip]+1
    def search_ip_sorted(self, pathfile):
        if not os.path.exists(pathfile):
            return

        for line in open(pathfile):
            for ip in re.findall( r'[0-9]+(?:\.[0-9]+){3}', line ):
                if not ip in self.ipc.keys():
                    self.ipc[ip]=0
                self.ipc[ip]=self.ipc[ip]+1
 


    

        
    def write_htm(self,htmfile):

        print "---", htmfile
        pf=open(htmfile,"w")
        pf.write("<table border='1'><tr><th>#</th><th>http hacker ip</th><th>activities</th><th>country</th></tr>")
        
        sorted_ipc = OrderedDict(sorted(self.ipc.items(), key=lambda t: t[1], reverse=True))
        idx=0
        for ip in sorted_ipc.keys():
            idx=idx+1
            country=ip2geo.get_country(ip)
            print ip, sorted_ipc[ip]
            pf.write("<tr><td>"+str(idx)+"</td><td>"+ip+"</td><td>"+ str(sorted_ipc[ip]) + "</td><td>"+country+"</td></td>")
        
        pf.write("</table>") 
        pf.write(ip2geo.ip2geo_dict())
        pf.close()
        
        
        

        
    def run(self):
        for pathfile in self.getfilelist():
            self.search_ip_sorted(pathfile)
        
        
        for ip in self.ipc.keys():
            print ip, self.ipc[ip]
            
        self.write_htm("/var/www/html/access_log_reader.htm")
        
aulog=auth_log_tmp()
     
exit(0)


























line='24.96.232.130 - - [18/Jun/2016:09:05:34 -0400] "GET /access_log_reader.php HTTP/1.1" 200 205 "-" "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36"'
regstr="^([\d\:\.]+)[\s]+[\-][\s]+[\-][\s]+\[([\w\d\/\:\s\-]+)\][\s]([^\r\n]+)"
#regstr="^([\d\:\.]+)[\s]+[\-][\s]+[\-][\s]+([^\r\n]+)"
reg=re.compile(regstr)
mat=reg.search(line)
if mat:
    print mat.group(1)
    print mat.group(2)
print "test end."
ip_arr=[]
        
filename="/var/log/apache2/access.log"
f = subprocess.Popen(['tail','-F',filename],stdout=subprocess.PIPE,stderr=subprocess.PIPE)


while True:
    line = f.stdout.readline()
    #print line
    mat=reg.search(line)
    if mat:
        ip=mat.group(1)
        dat=mat.group(2)
        #print ip,dat
        if not ip in ip_arr:
            print ip,dat
            ip_arr.append(ip)
    