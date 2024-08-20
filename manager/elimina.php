<?php
include("conndb.php");
$cod=$_GET['cod'];
$conn = @ new mysqli($servername, $username, $password, $dbase);
if($conn->connect_errno)
{ die ( "Connessione fallita: ".$connessione->connect_error. ".");}
$query="DELETE FROM Veicoli WHERE IdVeicolo='$cod'";
if($conn->query($query))
{echo "cancellazione veicolo ".$cod." effettuato con successo";
echo "<meta http-equiv='Refresh' content='3; URL=index.html'>";}
else
{echo "errore in fase di cancellazione:".$conn->error;}
$conn->close();
?>
