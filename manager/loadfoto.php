<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Carica Foto</title>
<link href="stilep.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<br />
<h1>ADRIATICA CAMION - CARICA FOTO</H1>
<ul id="nav">
	<li><a href="#">Gestione Veicoli</a>
	<ul>
			<li><a href="inserisci.html">Inserimento</a></li>
			<li><a href="ricerca.html">Ricerca</a></li>
	</ul>
	</li>

</ul>
<?php
if (isset($_POST['Invia']))
{
	$cod=$_POST["IdV"];
	$nome=$_POST["nome"];
	$nfoto=1;
	$target_dir = "../images/foto/";// 
	$target_file = $target_dir  . $cod . "_" . $nome . "_01.jpg";//basename($_FILES["fileToUpload"]["name"]);
	//echo $target_file . "<bR>";
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// Check if image file is a actual image or fake image
	if(isset($_POST["Invia"])) {
		//echo $_FILES["fileToUpload"]["tmp_name"];
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check != false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
	}
	// Check if file already exists
	if (file_exists($target_file)) {
		do
		{
			$nfoto++;
			$target_file=str_replace("_0" . ($nfoto-1),"_0" . $nfoto,$target_file);
			//echo $target_file . "<br>";
		}
		while ((file_exists($target_file)) && ($nfoto<6));
		//echo "Sorry, file already exists.";
		//$uploadOk = 0;
	}
	// Check file size
	/*if ($_FILES["fileToUpload"]["size"] > 500000) {
		echo "Sorry, your file is too large.";
		$uploadOk = 0;
	}*/
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
		echo $target_file . "<BR>";
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		} else {
			echo "Sorry, there was an error uploading your file." .$_FILES["file"]["error"];
		}
	}		
}
else{
	$cod=$_GET["cod"];
	$nome=$_GET["nome"];
}
?>
<br />
<form action="loadfoto.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="Invia">
    <input type="hidden" value="<?php echo $cod;?>" name="IdV">
    <input type="hidden" value="<?php echo $nome;?>" name="nome">
</form>
</body>
</html>