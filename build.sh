#! /bin/bash
now=$(date +"%y%m%d")
filename="hobo.beta.$now.tar.gz"
tar -pczf public/builds/$filename application/modules/hobo* public/hobo/ library/Hobo/
