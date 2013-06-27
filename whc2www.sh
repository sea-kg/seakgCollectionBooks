#!/bin/bash

#while [ 1 -eq 1 ]
#do
#	echo "cp"
	sudo rm -rf /var/www/whc/*
	sudo cp -R php/* /var/www/whc
	sudo chmod 777 -R /var/www/whc
#	sleep 2s
#done
