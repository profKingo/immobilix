{//PARTE DI AZZERAMENTO DEL VECCHIO RISULTATO
        $sql1 = "select * from Partite where idPart = " . $partita; 
        $rid = mysqli_query($conn, $sql1);
        $row=mysqli_fetch_assoc($rid);
        $golc = $row["golCasa"];
        $golf = $row["golFuori"];
		if ($golf>$golc){//vince squadra in trasferta
			$sqlclass="update Squadre set pg=pg-1, pv=pv-1, pt=pt-3, gf=gf-$golf, gs=gs-$golc where nome = '$ospi';";
			mysqli_query($link, $sqlclass);
			$sqlclass="update Squadre set pg=pg-1, pp=pp-1, gf=gf-$golc, gs=gs-$golf where nome = '$casa';";
			mysqli_query($link, $sqlclass);
		}
		else if ($golf==$golc){//pareggio
			$sqlclass="update Squadre set pg=pg-1, pn=pn-1, pt=pt-1, gf=gf-$golf, gs=gs-$golc where nome = '$ospi';";
			mysqli_query($link, $sqlclass);
			$sqlclass="update Squadre set pg=pg-1, pn=pn-1, pt=pt-1, gf=gf-$golc, gs=gs-$golf where nome = '$casa';";
			mysqli_query($link, $sqlclass);
		}
		else {//vince squadra in casa
			$sqlclass="update Squadre set pg=pg-1, pv=pv-1, gf=gf-$golf, gs=gs-$golc where nome = '$ospi';";
			mysqli_query($link, $sqlclass);
			$sqlclass="update Squadre set pg=pg-1, pp=pp-1, pt=pt-3, gf=gf-$golc, gs=gs-$golf where nome = '$casa';";
			mysqli_query($link, $sqlclass);
		}
      }//FINE PARTE DI AZZERAMENTO DEL VECCHIO RISULTATO
       //MODIFICO IL RISULTATO E AGGIORNO LE CLASSIFICHE 
      $sql1 = "update Partite set golCasa=$gc, golFuori=$gf," .
    	"inserita=1, ShootOut=$so, datains = CURRENT_DATE() where idPart='$partita'";
      if(mysqli_query($link, $sql1)){
        echo "<p align=center>Modifica effettuata correttamente!!!</p>";
		if ($gf>$gc){//vince squadra in trasferta
			$sqlclass="update Squadre set pg=pg+1, pv=pv+1, pt=pt+3, gf=gf+$gf, gs=gs+$gc where nome = '$ospi';";
			mysqli_query($link, $sqlclass);
			$sqlclass="update Squadre set pg=pg+1, pp=pp+1, gf=gf+$gc, gs=gs+$gf where nome = '$casa';";
			mysqli_query($link, $sqlclass);
		}
		else if ($gf==$gc){//pareggio
			$sqlclass="update Squadre set pg=pg+1, pn=pn+1, pt=pt+1, gf=gf+$gf, gs=gs+$gc where nome = '$ospi';";
			mysqli_query($link, $sqlclass);
			$sqlclass="update Squadre set pg=pg+1, pn=pn+1, pt=pt+1, gf=gf+$gc, gs=gs+$gf where nome = '$casa';";
			mysqli_query($link, $sqlclass);
		}
		else {//vince squadra in casa
			$sqlclass="update Squadre set pg=pg+1, pp=pp+1, gf=gf+$gf, gs=gs+$gc where nome = '$ospi';";
			mysqli_query($link, $sqlclass);
			$sqlclass="update Squadre set pg=pg+1, pv=pv+1, pt=pt+3, gf=gf+$gc, gs=gs+$gf where nome = '$casa';";
			mysqli_query($link, $sqlclass);
		}
      }