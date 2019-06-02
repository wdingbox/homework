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
        
        #pprint(self.IpGeo)
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

#############################
# https://www.iplocation.net/
ip2geo=Ip2Geo()

class auth_log_tmp:
    ipc={}
    def __init__(self):
        if len(sys.argv) >=2 :
            self.reg_search_uniq_cli()
            exit(0)
        self.mv2tmp()
        self.run()
    def mv2tmp(self):
        srcdir="/var/log/"
        for file in os.listdir(srcdir):
            #print file
            mat=re.compile("auth\.log\.[\d]+\.gz").search(file)
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
            mat=re.compile("auth\.log(\.[\d]+){0,}").search(file)
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
            mat=re.compile("auth[\.]log([\.][\d]+){0,}").search(file)
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
        pf.write("<table border='1'><tr><th>#</th><th>ssh hacker ip</th><th>activities</th><th>country</th></tr>")
        
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
            
        self.write_htm("/var/www/html/auth_log_reader.htm")
        
    def reg_search_uniq_cli(self):
        if "-s" in sys.argv:
            i=sys.argv.index("-s")
            regstr=sys.argv[i+1]
            unqidx=sys.argv[i+2]
            self.reg_search_uniq_cli_run(regstr,int(unqidx))
            return
            
    
        sams=["Failed password for ([^\s]+)[\s]+","Failed password for ([^\s]+)[\s]+from ([0-9]+(?:\.[0-9]+){3})"]
        print "samples of search:"
        for i, sam in  enumerate(sams):
            print i, sam
            
        
        regstr=raw_input("search reg:")
        if regstr.isdigit() :
            regstr=sams[int(regstr)]
            
        if ""==regstr:
            regstr="Failed password for ([^\s]+)[\s]+"
        print "search reg:", regstr
        unqidx=raw_input("uniq index:")
        if ""==unqidx:
            unqidx="1"
        unqidx=int(unqidx)
        if unqidx<0:
            unqidx=0
        print "uniq index:", str(unqidx)
        self.reg_search_uniq_cli_run(regstr,unqidx)
        
    def reg_search_uniq_cli_run(self,regstr, unqidx):
        reg=re.compile(regstr)
        Uniqfound={}
        _bv=False
        if "-v" in sys.argv:
            _bv=True
        for pathfile in self.getfilelist():
            self.search_ip_sorted(pathfile)
            for line in open(pathfile):
                mat=reg.search(line)
                if mat:
                    if _bv:
                        print line
                    foundstr=mat.group(unqidx)
                    if not foundstr in Uniqfound.keys():
                        Uniqfound[foundstr]=0
                    Uniqfound[foundstr]=Uniqfound[foundstr]+1                
        sorted_ipc = OrderedDict(sorted(Uniqfound.items(), key=lambda t: t[1], reverse=True))    
        idx=0
        for key in sorted_ipc.keys():
            idx=idx+1
            print idx, key, sorted_ipc[key]
            
        exit(0)
            

    
        

        
aulog=auth_log_tmp()
     
exit(0)

line='Jun 12 07:54:28 weid-VGN-AW290J sshd[20078]: Received disconnect from 121.18.238.31: 11:  [preauth]'
line='Jun 12 07:54:28 weid-VGN-AW290J sshd[20078]: Disconnected from 121.18.238.31 [preauth]'
line='Jun 12 07:54:28 weid-VGN-AW290J sshd[20078]: PAM 2 more authentication failures; logname= uid=0 euid=0 tty=ssh ruser= rhost=121.18.238.31  user=root'
line='Jun 12 07:54:30 weid-VGN-AW290J sshd[20080]: pam_unix(sshd:auth): authentication failure; logname= uid=0 euid=0 tty=ssh ruser= rhost=121.18.238.31  user=root'
line='Jun 12 07:54:32 weid-VGN-AW290J sshd[20080]: Failed password for root from 121.18.238.31 port 58960 ssh2'
line='Jun 12 07:54:36 weid-VGN-AW290J sshd[20080]: message repeated 2 times: [ Failed password for root from 121.18.238.31 port 58960 ssh2]'
regstr="^([\w]+[\s][\d]+[\s][\d\:]+)[\s]+([^\:]+)[\s]+([^\r\n]+)"
reg=re.compile(regstr)
mat=reg.search(line)
if mat:
    print mat.group(1)
    print mat.group(2)
    print mat.group(3)
print "-"

regstr="[\d]{1,3}[\:][\d]{1,3}[\:][\d]{1,3}[\:][\d]{1,3}"
reg=re.compile(regstr)
mat=reg.search(line)
if mat:
    print mat.group(1)

print "ip end=",  re.findall( r'[0-9]+(?:\.[0-9]+){3}', line )

reg=re.compile(regstr)
mat=reg.search(line)
if mat:
    print mat.group(1)
    print mat.group(2)
print "test end."
ip_arr=[]
        
filename="/var/log/auth.log"
f = subprocess.Popen(['tail','-F',filename],stdout=subprocess.PIPE,stderr=subprocess.PIPE)
while True:
    line = f.stdout.readline()
    ip_arr=re.findall( r'[0-9]+(?:\.[0-9]+){3}', line )
    print ip_arr,line
    for ip in ip_arr:
        if not ip in ip_arr:
            print ip,line
            ip_arr.append(ip)
    