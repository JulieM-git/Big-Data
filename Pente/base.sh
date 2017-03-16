#! /bin/bash
## Julie Marcuzzi

psql postgres -c "CREATE DATABASE projetpente;"

psql -d projetpente -c "CREATE EXTENSION postgis;"

psql -d projetpente -c "CREATE TABLE pente (
  lon numeric(25,5),
  lat numeric(25,5),
  pente_deg numeric(25,8)
);"

folder_csv='/home/prof/Bureau/CSV'

for filename in $folder_csv/*.csv; do
  psql -d projetpente -c "\copy pente FROM '$filename' WITH ENCODING 'UTF8' DELIMITER ',' CSV HEADER;"
done

psql -d projetpente -c "ALTER TABLE pente
ADD COLUMN geom geometry(Point, 4326);"

psql -d projetpente -c "UPDATE pente
SET geom = ST_SetSRID(ST_Point(cast(lon as double precision)
,cast(lat as double precision)), 4326);"

