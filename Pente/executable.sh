#! /bin/bash
## Julie Marcuzzi

path='/home/julie/Documents/BigData/BDALTIV2_2-0_75M_ASC_LAMB93-IGN69_FRANCE_2017-01-04/BDALTIV2/1_DONNEES_LIVRAISON_2017-02-00100/BDALTIV2_MNT_75M_ASC_LAMB93_IGN69_FRANCE'
folder_csv='/home/julie/Documents/BigData/BD_alti/CSV'
folder_tif='/home/julie/Documents/BigData/BD_alti/Tif'
folder_pente='/home/julie/Documents/BigData/BD_alti/Pente'

# Conversion TIF
for filename in $path/*.asc; do
  /usr/bin/gdal2xyz.py $filename $folder_tif/$(basename "$filename" .asc).tif
done

# Pente
for filename in $folder_tif/*.tif; do
  gdaldem slope $filename $folder_pente/$(basename "$filename" .tif).tif -of GTiff -b 1 -s 1 -compute_edges -p
done

# Conversion CSV
for filename in $folder_pente/*.tif; do
  /usr/bin/gdal2xyz.py -csv $filename $folder_csv/$(basename "$filename" .tif).csv
done

EOF
