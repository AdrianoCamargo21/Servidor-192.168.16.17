<!DOCTYPE html>
<html>
<head>
<title>Replica Videira</title>
<center><img src="img/fundo1.jpg"alt="10" heigth ="100px" width="400px" ></center>
</head>
</html>
<?php
date_default_timezone_set('America/Sao_Paulo');
$hora = date('H:i:s');
$hora_parte=explode(":",$hora);
$hora_h = $hora_parte[0];
$minuto = $hora_parte[1];
$segundo = $hora_parte[2];
?>
<HTML>
<HEAD>
<center>
  <script tpye=text/javascript>
var segundo=<?php echo $segundo;?>;
var minuto=<?php echo $minuto;?>;
var hora=<?php echo $hora_h;?>;
function tempo() {
	if (segundo<59) {
	   	segundo = segundo+1
	    if (segundo == 59){
		     minuto = minuto+1;
    	     segundo = 0;
		     if (hora == 24){
		        hora = hora+1;
    	        minuto = 0;
		        segundo = 0;
            }
         }
    }
	document.getElementById("relogio").innerHTML=(hora+":"+minuto+":"+segundo);
}
</script>
</center>
</HEAD>
<meta name = "GENERATOR" content = "MAX's HTML Beauty++ ME">
<body onload="setInterval('tempo();',1000)">
<div name = "relogio" id = "relogio"></div>
<BODY>
</BODY>
</HTML>
<?php header("Content-Type: text/html; charset=ISO-8859-1",true);?>
<?php
set_time_limit(0);
date_default_timezone_set('America/Sao_Paulo');
$time = date('H:i:s');
$dia = date('d-m-Y');
if(!@($servori = pg_connect ("host = 192.168.9.10 dbname = troll port = 5430 user = postgres password = ky$14gr@"))){
    echo "<p style = background: #000000; align = center <br/><b><font size = 30 color = #FF0000>ERRO!!! Sem Comunicação Banco de Dados de Origem Data: $dia  Hora: $time </font></b></p>";
    echo "<p style=background: #000000; align = center <br/><b><font size = 10 color = #7CFC00>Caso Persista Favor avisar o Adriano</font></b></p>";
    ?>
    <!DOCTYPE html>
    <html>
    <head>
    <meta http-equiv = 'refresh' content = '10' url = http://127.0.0.1/replica/trollvdr.php';'>
    <center><img src = "img/error.jpg"alt="500" heigth ="500px" width="100px" ></center>
	</head>
	</html>
	<?php header("Content-Type: text/html; charset=ISO-8859-1",true);?>
	<?php
    exit;
} else {
    echo "<p style = background:#D3D3D3; align = center <br/><b><font size=5 color=#FF0000>Servidor de Origem : Troll Conectado</font></b></p>";
}
if(!@($servdest = pg_connect ("host = 192.168.16.190 dbname = troll_videira port = 5430 user = postgres password = ky$14gr@"))){
    echo "<p style = background: #000000; align = center <br/><b><font size = 30 color = #FF0000>ERRO!!! Sem Comunicação Banco de Dados de Destino Data: $dia  Hora: $time </font></b></p>";
    echo "<p style=background: #000000; align = center <br/><b><font size = 10 color = #7CFC00>Caso Persista Favor avisar o Adriano</font></b></p>";
    ?>
    <!DOCTYPE html>
    <html>
    <head>
    <meta http-equiv = 'refresh' content = '10' url = http://127.0.0.1/replica/trollvdr.php';'>
    <center><img src = "img/error.jpg"alt="500" heigth ="500px" width="100px" ></center>
	</head>
	</html>
	<?php header("Content-Type: text/html; charset=ISO-8859-1",true);?>
	<?php
    exit;
} else {
    echo "<p style = background:#D3D3D3; align = center <br/><b><font size=5 color=#FF0000>Servidor de Destino : Troll_Videira Conectado</font></b></p>";
}
$codini = 2280622; //Códifo Inicial da Replicação

$sql = "select *from log where codigo >= $codini and tabela <> 'versao_bd' and substituto is null order by codigo limit 1 ";echo $sql.'<br>';
$exsql=pg_query($servori,$sql);
if (!$exsql){
    echo "<p style=background:#000000; align=center <br/><b><font size=30 color=#FF0000>Erro Ao Buscar Logs Na Tabela de Origem Data:$dia  Hora:$time </font></b></p>";
    pg_close($con);pg_close($destino);
    exit;
}
$rsql = pg_fetch_array($exsql);
if ($rsql == null) {
    pg_close($servori);pg_close($servdest);
    echo "<p style=background:#F5F5DC; align=center <br/><b><font size=30 color=#00FF00>Nada Para Replicar em: '$dia' , '$time'  </font></b></p>";
    ?>
    <!DOCTYPE html>
    <html>
    <head>
    <meta http-equiv = 'refresh' content = '5' url = http://127.0.0.1/replica/trollvdr.php';'>
   <center><img src = "https://i.gifer.com/1FA.gif" width = "280"  heigth = "269"  frameBorder = "0" class = "giphy-embed" width = "200px" ></center>
	</head>
	</html>
	<?php header("Content-Type: text/html; charset=ISO-8859-1",true);?>
	<?php
    exit;
}
$com = "delete from tplog ";echo $com.'<br>';
$excom = pg_query($servdest,$com);
$sql = "BEGIN";
$exsql = pg_query($servdest,$sql);
$sql = "select *from log where codigo > $codini and tabela <> 'versao_bd' and substituto is null order by codigo limit 100 ";echo $sql.'<br>';//
$exsql = pg_query($servori,$sql);
while($dados = pg_fetch_array($exsql)){
    $codigo = $dados['codigo'];
    $data = $dados['datal'];
    $hora = $dados['hora'];
    $operacao = $dados['operacao'];
    $tabela = $dados['tabela'];
    $usuario = $dados['usuario'];
    $antes = $dados['antes'];
    $antes = str_replace(chr(39),'',$antes);
    $depois = $dados['depois'];
    $depois = str_replace(chr(39),'',$depois);
    $codusiario = $dados['cod_usu'];
    if ($codusiario == null) {
        $codusiario = 'NULL';
    }
    $com = "insert into tplog values($codigo,'$data','$hora','$operacao','$tabela','$usuario','$antes','$depois',$codusiario,NULL,NULL)";echo $com.'<br>';
    $excom = pg_query($servdest,$com);
    if (!$excom) {
        echo "<p style=background:#000000; align=center <br/><b><font size=30 color=#FF0000>Erro Ao Copiar O C�gigo = $codigo</font></b></p>";
        $com= " ROLLBACK";
        $excom = pg_query($servdest,$com);
        pg_close($servori);pg_close($servdest);
        exit;
    }
    $com = "select logar('REPLICADOR',1,0); SELECT addtolog( codigo , datal , hora , tabela , operacao , antes , depois , usuario , 0 ) from tplog where codigo = $codigo";echo $com.'<br>';
    $excom = pg_query($servdest,$com);
    if (!$excom) {
        $com= " ROLLBACK";
        $excom = pg_query($servdest,$com);
        echo "<p style=background:#000000; align=center <br/><b><font size=30 color=#FF0000>Erro Ao Replicar O C�gigo = $codigo</font></b></p>";
        pg_close($servori);pg_close($servdest);
        exit;
    }
    $com = "update log set substituto = '1' where codigo = $codigo "; echo $com.'<br>';
    $excom=pg_query($servori,$com);
    if (!$excom) {
        $com= " ROLLBACK";
        $excom = pg_query($servdest,$com);
        echo "<p style=background:#000000; align=center <br/><b><font size=30 color=#FF0000>Erro ao atalizar o Substituto do Log</font></b></p>";
        pg_close($servori);pg_close($servdest);
        exit;
    }
    $com = "delete from tplog ";echo $com.'<br>';
    $excom = pg_query($servdest,$com);
    if (!$excom) {
        echo "<p style=background:#000000; align=center <br/><b><font size=30 color=#FF0000>Erro ao Apagar Logs</font></b></p>";
        $excom = pg_query($servdest,$com);
        $com= " ROLLBACK";
        $excom = pg_query($servdest,$com);
        pg_close($servori);pg_close($servdest);
        exit;
    } 
    $com = "COMMIT";echo $com.'<br>';
    $excom = pg_query($servdest,$com);
    if (!$excom) {
        echo "<p style=background:#000000; align=center <br/><b><font size=30 color=#FF0000>Erro ao Gravar Informaçoes</font></b></p>"; 
        $excom = pg_query($servdest,$com);
        pg_close($servori);pg_close($servdest);
        exit;
    }  
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv='refresh' content='5' url=http://127.0.0.1/replica/trollvdr.php';'>
<center><img src="https://media.giphy.com/media/11JTxkrmq4bGE0/giphy.gif" width="480"  heigth ="369"  frameBorder="0" class="giphy-embed" width="200px" ></center>
</head>
</html>