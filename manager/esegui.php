<?php
$command= 'python C:/immobilix/cercaaste.py'; 
exec($command, $out, $status); 
echo($out[0]);
echo "<meta http-equiv='Refresh' content='2; URL=index.html'>";
?>