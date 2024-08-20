<html>
<head>
<title> Modifica record </title>
<link href="stilep.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<h1>ADRIATICA CAMION - MODIFICA RECORD</H1>
<br>
<ul id="nav">
	<li><a href="#">Gestione Veicoli</a>
	<ul>
			<li><a href="inserisci.html">Inserimento</a></li>
			<li><a href="ricerca.html">Ricerca</a></li>
	</ul>
	</li>

</ul>

<?php
include("conndb.php");

//Si assegnano alla variabile il campo codice proveniente dal form 
if (isset($_POST["codice"]))
	$cod=$_POST["codice"];
else
	$cod=$_GET["cod"];
//Connessione al database
$conn = @ new mysqli($servername, $username, $password, $dbase);

// verifica su eventuali errori di connessione
if ($conn->connect_errno) 
	{
    die("<h2>Connessione fallita: ". $connessione->connect_error . ".</h2>");  
	}
	
//se hai premuto il submit del form modifica	
if(isset($_POST['modifica']))    
	{
//si assegnano alle variabili i campi modificati nel form
	$cod=$_POST['codice'];
	$nome=addslashes($_POST['nome']);
	$descr=addslashes($_POST['descrizione']);
	$anno=$_POST['anno'];
	$prezzo=$_POST['prezzo'];
//si prepara la stringa di aggiornamento
	$query="UPDATE Veicoli SET Nome='$nome', Descrizione='$descr', Prezzo=$prezzo, Anno=$anno WHERE IdVeicolo='$cod'";
	if ($conn->query($query)) 
		{
			echo "<h2>Modifica del record ".$cod." effetuata con successo</h2>";
		} 
	else 	
		{
			echo "<h2>Errore in fase di modifica: " . $conn->error ."</h2>";
		}
	
			
//qui il ritorno automatico alla pagina in cui visualizzi l'elenco usando il tag meta
	echo "<meta http-equiv='Refresh' content='4; URL=index.html'>";
	}
else 
//se la pagina è chiamata per la prima volta e non abbiamo ancora nodificato nel form
	{

		$query = "SELECT IdVeicolo, Nome, Descrizione, Prezzo, Anno FROM Veicoli WHERE IdVeicolo='$cod'";
		$risultato = @ $conn->query($query);
		if ($conn->errno) 
			{die ("<p>Errore nell'esecuzione della query</p>");}		
			
		if (@ $risultato->num_rows !=0)
		{	$row = $risultato->fetch_array(MYSQLI_ASSOC);	
	
			echo "<form action=".$_SERVER['PHP_SELF']." method='post' name='modificare'>
			<table width='100%' border='0' cellspacing='0' cellpadding='0'>
			<tr>
				<td>Nome: <input type='text' name='nome' value=" . 
					$row['Nome']." required></td>
				<td>Descrizione:<input type='text' name='descrizione' value=" .	$row['Descrizione']." required></td>
				<td>Prezzo:<input type='text' name='prezzo' value=" . $row['Prezzo']." required></td>
				<td>Anno:<input type='text' name='anno' value=" . $row['Anno']."></td>
				<td><input type='hidden' name='codice' value=" . $row['IdVeicolo'].">
					<input name='modifica' type='submit' value='modifica' id='modifica'>
					</td>
				<!--td><input name='elimina' type='submit' value='elimina' id='elimina'>
					</td-->
			</tr>
			</table>
			</form>";
		}
		else  {("<p>Nessun risultato nell'esecuzione della query</p>");}	
	}    
?>
</body>
</html>
