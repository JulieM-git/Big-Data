#! /bin/bash

path='/home/julie/Documents/BDALTIV2_2-0_75M_ASC_LAMB93-IGN69_FRANCE_2017-01-04/BDALTIV2/1_DONNEES_LIVRAISON_2017-02-00100/BDALTIV2_MNT_75M_ASC_LAMB93_IGN69_FRANCE'
folder='/home/julie/Documents/BD_alti'
for filename in $path/*.asc; do
  /usr/bin/gdal2xyz.py -csv $filename $folder/$(basename "$filename" .asc).csv
done
