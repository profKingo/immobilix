def cerca(file_in):
    tabfinale=[]
    res=[]
    res.append(("Indirizzo", "Città", "Prov", "Prezzo", "Tipo asta", "Ragione d'asta", "Tribunale", "Ruolo", "Anno", "Tipo vendita", "Data vendita", "Lotto", "Asta", "Descrizione","Link", "Foto")) 
    f=open(file_in,"r",encoding="UTF-8")
    frase=f.readline().strip()
    while not frase.startswith("<!-- Content"):
        frase=f.readline()
    frase=f.readline()
    while not frase.startswith("<!-- Wrapper / End -->"):
        frase=f.readline().strip()
        if frase.startswith("<div class=\"listing-badges\">"):
            frase=f.readline().strip()
            tipoasta=frase[39:frase.find("</span>")]
        if frase.startswith("<span class=\"listing-price\">"):
            prezzo=frase[29:frase.find("</span>")]
            prezzo=prezzo.replace("€","")
            prezzo=prezzo.replace(".","")
        if frase.startswith("<div class=\"listing-carousel\">"):
            frase=f.readline().strip()
            frase=f.readline().strip()
            foto=frase[10:frase.find("\" alt=\"")]
        if frase.startswith("<em class=\"im im-icon-Map-Marker2\"></em>"):
            frase=f.readline().strip()
            indirizzo=frase[:frase.find("<br>")]
            frase=f.readline().strip()
            frase=f.readline().strip()
            citta=frase[:frase.find("(")]
            prov=frase[frase.find("(")+1:frase.find(")")]
        if frase.startswith("<ul class=\"listing-details second-row\">"):
            frase=f.readline().strip()
            tribunale=frase[38:frase.find("</li>")]
            frase=f.readline().strip()
            tipoasta2=frase[25:frase.find("</li>")]
            frase=f.readline().strip()
            ruolo=frase[25:frase.find("<span class")]
            anno=frase[frase.find("<span class=\"anno-procedura\">")+30:frase.find("</span></li>")]
        if frase.startswith("<ul class=\"listing-details\" id=\"preferiti\">"):
            frase=f.readline().strip()
            tipovendita=frase[25:frase.find("</li>")]
            frase=f.readline().strip()
            datavendita=frase[50:frase.find("</li>")]
            frase=f.readline().strip()
            frase=f.readline().strip()
            if frase.__contains__("lotti"):
                lotto=frase[31:frase.find("</li>")]
                frase=f.readline().strip()
                asta=frase[39:frase.find("</li>")]
        if frase.startswith("<span class=\"ellipsis-description\">"):
            descrizione=frase[35:frase.find("</span>")]
            descrizione = descrizione.replace(";",".")
            descrizione = descrizione.replace("\"","'")
            frase=f.readline().strip()
            link=frase[9:frase.find("\" class=")]
            link = link.replace("&#39;","'")
            res.append((indirizzo, citta, prov, prezzo, tipoasta, tipoasta2, tribunale, ruolo, anno, tipovendita, datavendita, lotto, asta, descrizione, link, foto))
    #res.sort()
    fcsv = open("c:\Aste\listaaste.csv", "w")
    i=0
    for t in res:
        if i>0:
            for e in t:
                if e!="":
                    fcsv.write(e)
                    fcsv.write(";")
            fcsv.writelines("\n")
        sheetimm.append(t)
        i=i+1
    fcsv.close()   
    
    f.close()
    return res

import time 
import openpyxl
import os

"""print("*******************MANUALE D'USO**************************************")
print("* SALVARE LE PAGINE DI RICERCA SU ASTEGIUDIZIARIE.IT COME ASTE.HTML  *")
print("* ELIMINARE PRIMA LE VECCHIE PAGINE SCARICATE MAGARI SALVANDOLE      *")
print("*******************MANUALE D'USO**************************************")
"""
#esegui=input("Vuoi eseguire il calcolo?(S/N)")
esegui="S"
if esegui.upper()=="S":
    #print("Elaborazione in corso...")     
    nuovo_file = openpyxl.Workbook()
    nuovo_file.save("C:/Aste/AsteGiudiziarie.xlsx")
    sheetimm = nuovo_file.active
    ########## GESTIONE INVIO FTP ############
    path="C:/Aste/aste.html"  #
    print (os.curdir)
    if os.path.exists(path):
        sheetimm.title="Aste"
        cerca(path)
        nuovo_file.save("C:/Aste/AsteGiudiziarie.xlsx")   #
    else:
        print("file not found")
    import ftplib
    FTP_HOST = "ftp.gicosoft.it"  
    FTP_USER = "8165253@aruba.it"
    FTP_PASS = "GaiaYumi21!"
    ftp = ftplib.FTP()
    port = 21
    ftp.connect(FTP_HOST, port)
    print (ftp.getwelcome())
    try:
        print ("Logging in...")
        ftp.login(FTP_USER, FTP_PASS)
    except:
        "failed to login"""
    localfile='C:/Aste/listaaste.csv'
    remotefile='aste/listaaste.csv'
    ftp.cwd("gicosoft.it")
    file=open(localfile, "rb")
    ftpresp=ftp.storlines('STOR %s' % remotefile, file)
    print(ftpresp)
    ########## GESTIONE COPIA FILES ############
    dir_path = r'C:/Aste/aste_files'
    for path in os.listdir(dir_path):
        if path.startswith("2") and os.path.isfile(os.path.join(dir_path, path)):  
            if (time.time() - os.path.getatime(os.path.join(dir_path, path))) < 3600 * 24:
                print ("Buono")
            else:
                print(time.time())
                print(os.path.getatime(os.path.join(dir_path, path)))
            if path.find("jpg")<0:
                os.rename(dir_path + "/" + path, dir_path + "/" + path + ".jpg")
                path = path + ".jpg"
            file=open(os.path.join(dir_path, path), "rb")
            remotefile='aste/aste_files/' + path
            ftpresp=ftp.storbinary('STOR %s' % remotefile, file, 1024)
            file.close()
            os.remove(os.path.join(dir_path, path))
    # quit and close the connection
    ftp.quit()
    time.sleep(1.5)
    print("Elaborazione terminata...")     
    

