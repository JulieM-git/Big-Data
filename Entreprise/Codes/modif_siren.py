import csv
from Dico_voie import dicoVoie

fichier_entree = open("Data/siren_93.csv","r")
cr = csv.reader(fichier_entree, delimiter=';')

fichier_sortie = open("siren_93_modif3.csv", "w")
cw = csv.writer(fichier_sortie, delimiter=';',lineterminator = "\n")



for row in cr:
    t ='';
    if dicoVoie.has_key(row[18]):
        t = dicoVoie.get(row[18])

    nv = row[16]+row[17]
    ad=t+" "+row[19]
    cw.writerow([row[0],row[1],nv,ad,row[20],row[28],row[36],row[43],row[60]])


fichier_entree.close()
fichier_sortie.close()