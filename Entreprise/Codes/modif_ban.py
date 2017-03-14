import csv

fichier_entree = open("Data/BAN_93.csv","r")
cr = csv.reader(fichier_entree, delimiter=';')

fichier_sortie = open("BAN_93_modif3.csv", "w")
cw = csv.writer(fichier_sortie, delimiter=';',lineterminator = "\n")



for row in cr:
    if row[4]=="BIS" :
        a = "B"
    elif row[4]=="TER":
        a = "T"
    elif row[4]=="QUATER":
        a = "Q"
    elif row[4]=="QUINQUIES":
        a = "C"
    else:
        a = row[4]

    nv = row[3] + a
    cw.writerow([row[0],nv,row[5],row[6],row[9],row[10],row[11],row[12],row[13],row[14]])


fichier_entree.close()
fichier_sortie.close()