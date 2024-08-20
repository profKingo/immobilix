<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Pannello Amministrazione</title>
<link href="stilep.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<h1>GESTIONE IMMOBILI ASTE - PANNELLO DI GESTIONE</h1>
<br>
<ul id="nav">
	<li><a href="#">Gestione Immobili</a>
	<ul>
		<li><a href="index.html">Ritorna alla pagina principale</a></li>
	</ul>
	</li>
</ul>
<br>
<?php
include("conndb.php");
//si effettua la connessione
//creo una stringa per personalizzare la query a seconda dei criteri immessi
$where=" ";
if (!empty($_POST["nome"]))
{
	$nome = $_POST["nome"]; 
	$where = $where . " and Nome LIKE '%$nome%'";
}
// esecuzione della query per la selezione dei record
$query="SELECT * FROM immobili WHERE 1=1" . $where;
$result = $conn->query($query);
// Se il numero di record prelevati dalla tabella e presenti in $result è > 0 visualizzo i record
if($result->num_rows > 0)
 {
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>Città</td>
    <td>Descrizione</td>
    <td>Prezzo</td>
    <td>Modifica</td>
  </tr>
<?php
while($row = $result->fetch_array(MYSQLI_ASSOC))
{ 
	echo "<tr> <td>" . $row['citta'] . "</td>  <td>";
	echo $row['descrizione'] . "</td>  <td>";
    echo $row['codasta'] . "</td>  <td>";
	echo $row['citta'] . "</td>";
	echo "<td> <a href='modificarec.php?cod=" .$row['idimm'] . "'>Pubblica</a> </td>";
	echo "</tr>";
}
?> 
<tr><td colspan=4> <a href='loadfromcsv.php'>Carica da csv</a> </td></tr>
</table>
<?php 
 // liberazione delle risorse occupate dal risultato
 $result->close();
}
else
{
 echo"<br><br><center><h2>Non ci sono immobili </h2><br>";
}
$conn->close(); // chiusura della connessione
?>
</body>
</html>