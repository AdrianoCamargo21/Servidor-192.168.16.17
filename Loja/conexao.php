<?php
date_default_timezone_set('America/Sao_Paulo');
$time=date('H:i:s');
$dia= date('d-m-Y');
if(!@($serv=pg_connect ("host=127.0.0.1 dbname=viabrasil port=5430 user=postgres password=ky$14gr@"))){
    echo "<p style=background:#000000; align=center <br/><b><font size=5 color=#FF0000>ERRO!!! Sem Comunica��o Banco de Dados de Ca�ador Data:$dia  Hora:$time </font></b></p>";
    echo "<p style=background:#000000; align=center <br/><b><font size=5 color=#7CFC00>Caso Persista Favor avisar o Adriano</font></b></p>";
    ?>
    <!DOCTYPE html>
    <html>
    <head>
    <center><img src="img/Silvioerro.png"alt="100px" heigth ="100px" width="100px" ></center>
    <link rel="stylesheet" href="css/style.css"></link>
	<center><form name = "form1" method= "post" action= "index.php"></center>
	<br><br>
	<center><input class="btn btn-red"  type="submit"  value="Tentar Novamente"></center>
	</head>
	</html>
	<?php header("Content-Type: text/html; charset=ISO-8859-1",true);?>
	<?php
    exit; 
}
if(!@($conc=pg_connect ("host=192.168.16.190 dbname=troll_cdr port=5430 user=postgres password=ky$14gr@"))){
    echo "<p style=background:#000000; align=center <br/><b><font size=5 color=#FF0000>ERRO!!! Sem Comunica��o Banco de Dados de Ca�ador Data:$dia  Hora:$time </font></b></p>";
    echo "<p style=background:#000000; align=center <br/><b><font size=5 color=#7CFC00>Caso Persista Favor avisar o Adriano</font></b></p>";
    ?>
    <!DOCTYPE html>
    <html>
    <head>
    <center><img src="img/Silvioerro.png"alt="100px" heigth ="100px" width="100px" ></center>
    <link rel="stylesheet" href="css/style.css"></link>
	<center><form name = "form1" method= "post" action= "index.php"></center>
	<br><br>
	<center><input class="btn btn-red"  type="submit"  value="Tentar Novamente"></center>
	</head>
	</html>
	<?php header("Content-Type: text/html; charset=ISO-8859-1",true);?>
	<?php
    exit; 
}
if(!@($conv=pg_connect ("host=192.168.16.190 dbname=troll_videira port=5430 user=postgres password=ky$14gr@"))){
    echo "<p style=background:#000000; align=center <br/><b><font size=5 color=#FF0000>ERRO!!! Sem Comunica��o Banco de Dados de Videira Data:$dia  Hora:$time </font></b></p>";
    echo "<p style=background:#000000; align=center <br/><b><font size=5 color=#7CFC00>Caso Persista Favor avisar o Adriano</font></b></p>";
    ?>
    <!DOCTYPE html>
    <html>
    <head>
    <center><img src="img/Silvioerro.png"alt="100px" heigth ="100px" width="100px" ></center>
    <link rel="stylesheet" href="css/style.css"></link>
	<center><form name = "form1" method= "post" action= "index.php"></center>
	<br><br>
	<center><input class="btn btn-red"  type="submit"  value="Tentar Novamente"></center>
	</head>
	</html>
	<?php header("Content-Type: text/html; charset=ISO-8859-1",true);?>
	<?php
    exit; 
}
if(!@($conl=pg_connect ("host=192.168.16.190 dbname=troll_lages port=5430 user=postgres password=ky$14gr@"))){
    echo "<p style=background:#000000; align=center <br/><b><font size=5 color=#FF0000>ERRO!!! Sem Comunica��o Banco de Dados de Lages Data:$dia  Hora:$time </font></b></p>";
    echo "<p style=background:#000000; align=center <br/><b><font size=5 color=#7CFC00>Caso Persista Favor avisar o Adriano</font></b></p>";
    ?>
    <!DOCTYPE html>
    <html>
    <head>
    <center><img src="img/Silvioerro.png"alt="100px" heigth ="100px" width="100px" ></center>
    <link rel="stylesheet" href="css/style.css"></link>
	<center><form name = "form1" method= "post" action= "index.php"></center>
	<br><br>
	<center><input class="btn btn-red"  type="submit"  value="Tentar Novamente"></center>
	</head>
	</html>
	<?php header("Content-Type: text/html; charset=ISO-8859-1",true);?>
	<?php
    exit; 
}
if(!@($conj=pg_connect ("host=192.168.16.190 dbname=troll_joinville port=5430 user=postgres password=ky$14gr@"))){
    echo "<p style=background:#000000; align=center <br/><b><font size=5 color=#FF0000>ERRO!!! Sem Comunica��o Banco de Dados de Lages Data:$dia  Hora:$time </font></b></p>";
    echo "<p style=background:#000000; align=center <br/><b><font size=5 color=#7CFC00>Caso Persista Favor avisar o Adriano</font></b></p>";
    ?>
    <!DOCTYPE html>
    <html>
    <head>
    <center><img src="img/Silvioerro.png"alt="100px" heigth ="100px" width="100px" ></center>
    <link rel="stylesheet" href="css/style.css"></link>
	<center><form name = "form1" method= "post" action= "index.php"></center>
	<br><br>
	<center><input class="btn btn-red"  type="submit"  value="Tentar Novamente"></center>
	</head>
	</html>
	<?php header("Content-Type: text/html; charset=ISO-8859-1",true);?>
	<?php
    exit; 
}	
?>