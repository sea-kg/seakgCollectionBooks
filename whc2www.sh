#!/bin/bash

#while [ 1 -eq 1 ]
#do
#	echo "cp"
	sudo rm -rf /var/www/whc/*
	sudo cp -R php/* /var/www/whc
	sudo chmod 777 -R /var/www/whc
	sudo cp -R /var/www/collection-films/posters/* /var/www/whc/collection-films2/posters
#	sleep 2s
#done
