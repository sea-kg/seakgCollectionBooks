#!/bin/bash

## removing old data
if [ ! -d collection_books_backup ];
then
	mkdir collection_books_backup
fi

if [ -d project_security ];
then
	cp -rf collection_books/* collection_books_backup
fi

rm -rf collection_books
mkdir  collection_books

## coping new data
FILE1=$(echo "$(pwd)/$1/php/*");

cp -rf $FILE1 collection_books

## configure
# chmod 777 -R collection_books/*

#copy config file if exists
if [ -f config.php ]; then
	cp -rf config.php collection_books/config.php
else
	cp collection_books/config.php config.php
fi

## restore scans
if [ -d project_security -a -d collection_books_backup/scans ];
then
	rm -rf collection_books/scans
	cp -rf collection_books_backup/scans collection_books/scans
fi

## changes access to files
chmod 777 -R project_security/*
