#!/bin/bash

# put all zip files into 
MYTARGETDIR="../../../../../___bigdata/unzipped/rel/ham12"
#MYTARGETDIR="./testb"
MYRESOURCES="./"
#MYRESOURCE="./testa"

if [ ! -d "$MYRESOURCES" ]; then
  # Control will enter here if $DIRECTORY doesn't exist.
  echo "MYRESOURCES= ${MYRESOURCES} not exist" 
  ######mkdir -p ${MYRESOURCES}
  exit 1
fi

if [ ! -d "$MYTARGETDIR" ]; then
  # Control will enter here if $DIRECTORY doesn't exist.
  echo "MYTARGETDIR= ${MYTARGETDIR} not exist" 
  mkdir -p ${MYTARGETDIR}
  exit 1
fi


cmd="ls -l ${MYRESOURCES}"
echo "${cmd}"
${cmd}
echo '---'
sleep 3
cmd="ls -l ${MYTARGETDIR}"
echo "${cmd}"
${cmd}

echo "---"
sleep 3

#uncompress the compressed folder by: 
# tar -zcvf zcvf.tar.gzip foldername
for filename in `ls ${MYRESOURCES}*.tar.*`; do
    cmd="tar xf ${MYRESOURCES}/$filename -C ${MYTARGETDIR}"
    echo ${cmd}
    echo "..."
    sleep 3
    ${cmd}    
done


cmd="ls -l ${MYTARGETDIR}"
echo "${cmd}"
${cmd}



