<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Inserimento</title>
<link href="stilep.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<h1>ADRIATICA CAMION - INSERIMENTO</H1>
<?php
include("conndb.php");
//Si assgnano alle variabili i campi provenienti dal form
$nome=str_replace(" ", "_", addslashes($_POST['nome']));
$descr=addslashes($_POST['descr']);
$prezzo=$_POST['prezzo'];
$anno=$_POST['anno'];
//Connessione al database
$conn = @ new mysqli($servername, $username, $password, $dbase);
// verifica su eventuali errori di connessione
if ($conn->connect_errno)
{
 die("Connessione fallita: " . $conn->connect_error . ".");
 }
// inserimento di dati in una tabella con MySQLi
// esecuzione della query per l'inserimento dei record, l’ID_agenda è un contatore con autoincremento
if (!$conn->query("INSERT INTO Veicoli (Nome, Descrizione, Prezzo, Anno) VALUES ('$nome', '$descr', $prezzo, $anno)"))
{
echo "Errore della query: " . $conn->error . query . ".";
}
else {
echo "<h2>Inserimento effettuato correttamente.</h2>";
}
// chiusura della connessione
$conn->close();
//qui il ritorno automatico alla pagina in cui visualizzi l'elenco usando il tag meta
	echo "<meta http-equiv='Refresh' content='4; URL=index.html'>";
?>
</body>
</html>