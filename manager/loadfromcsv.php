<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pagina di conferma login</title>
    
<link href="../style.css" rel="stylesheet" type="text/css" />
</head>

<body class="cella">
<form action="login.php" method=post>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" id="ombred">
  <tr>
    <td colspan="2" class="cella"><p><img src="../images/header.png" width="350" height="85" />
    </tr>
  <tr>
    <td width="350" class="cella">
<?php
include ("conndb.php");
function controlla($str){
    $str = str_replace("'", "''", $str);
    //str_replace("\"", "''", $str);
    return $str;
}
$row = 1;
if ($conn->errno)
{
	die ("errore nell'esecuzione della query");
}
/*$querydel="DELETE FROM artisti WHERE 1=1";
$risultato=mysqli_query($conn, $querydel);
if ($risultato)
{
	echo "Artisti cancellati!" . "<BR>";
}
$querydel="DELETE FROM voti WHERE 1=1";
$risultato=mysqli_query($conn, $querydel);
if ($risultato)
{
	echo "Voti cancellati!\n" . "<BR>";
}
*/
$fp = fopen('loadlist.txt', 'w');
if (($handle = fopen("C:\immobilix\listaaste.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        $data = str_replace("\n", "", $data);
		$num = count($data);
        $row++;
        if($num>1){
    //indirizzo, citta, prov, prezzo, tipoasta, tipoasta2, 
    //tribunale, ruolo, anno, tipovendita, datavendita, lotto, asta, link, foto
			$indirizzo=controlla($data[0]);
            $citta=controlla($data[1]);
			$prov=$data[2];
			$prezzo=str_replace(",", ".", $data[3]);
			$tipoasta=controlla($data[4]);
			$tipoasta2=controlla($data[5]);
			$tribunale=controlla($data[6]);
			$ruolo=controlla($data[7]);
			$anno=$data[8];
			$tipovendita=$data[9];
			$datavendita=date("Y-m-d", strtotime(str_replace("/", "-", $data[10])));
            echo $datavendita . "<BR>";
			$lotto=$data[11];
			$codasta=$data[12];
			$descr=controlla($data[13]);
			$link=$data[14];
			$foto=$data[15];
			$queryinserimento="INSERT INTO immobili(indirizzo, citta, prov, prezzo, tipoasta, tipoasta2,tribunale, ruolo, anno, tipovendita, datavendita, lotto, codasta, link, foto, descrizione) ";
            $queryinserimento=$queryinserimento . "VALUES ('$indirizzo', '$citta', '$prov', $prezzo, '$tipoasta', '$tipoasta2', '$tribunale', '$ruolo', $anno, '$tipovendita', '$datavendita', '$lotto', $codasta, '$link', '$foto', '$descr');";
			//echo $queryinserimento . "<br>";
			fwrite($fp, $queryinserimento . chr(13));
			$risultato=mysqli_query($conn, $queryinserimento);
			if ($risultato)
			{
				fwrite($fp, "Inserimento effettuato!!!" . chr(13));
			}
			else
				fwrite($fp, $conn->error . chr(13));
        }
    }
	echo "Operazione Terminata!";
    fclose($handle);
}
fclose($fp);
//echo "<meta http-equiv='Refresh' content='5; URL=lista.php'>";
?></td>
  </tr>
</table>
</form>
</body>
</html>
