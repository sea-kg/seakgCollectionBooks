#!/bin/sh

## downloading data
rm -rf temp_
mkdir temp_
cd temp_
wget --user-agent "firefox" https://github.com/seakg/seakgCollectionBooks/archive/master.zip

## unpacking
unzip master.zip
cd ..

chmod +x temp_/seakgCollectionBooks-master/configure.sh
bash temp_/seakgCollectionBooks-master/configure.sh 'temp_/seakgCollectionBooks-master'

rm -rf temp_
