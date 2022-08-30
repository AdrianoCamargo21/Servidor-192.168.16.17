<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<br><br>
</html>
<?php header("Content-Type: text/html; charset=ISO-8859-1",true);?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$time=date('H:i:s');
$dia= date('Y-m-d');
$hoje =  date('Y-m-d');
function soNumero($str) {
    return preg_replace("/[^0-9]/", "", $str);
}
function formatar_cpf_cnpj($doc) {
    
    $doc = preg_replace("/[^0-9]/", "", $doc);
    $qtd = strlen($doc);
    
    if($qtd >= 11) {
        
        if($qtd === 11 ) {
            
            $docFormatado = substr($doc, 0, 3) . '.' .
                substr($doc, 3, 3) . '.' .
                substr($doc, 6, 3) . '-' .
                substr($doc, 9, 2);
        } else {
            $docFormatado = substr($doc, 0, 2) . '.' .
                substr($doc, 2, 3) . '.' .
                substr($doc, 5, 3) . '/' .
                substr($doc, 8, 4) . '-' .
                substr($doc, -2);
        }
        
        return $docFormatado;
    }
        
}

include_once("conexao.php");
$com = "delete from parcelas";
$excom=pg_query($serv,$com);
$com = "begin";
$excom=pg_query($serv,$com);

$volta="<script>window.location='http://192.168.16.17/loja'</script>";
date_default_timezone_set('America/Sao_Paulo');
set_time_limit(0);
$tipo = $_POST['tipo'];
if ($tipo == null) {
    echo $volta; exit;
}
if ($tipo == 'CO') {
    $cod = $_POST['C'];
    if ($cod == null) {
        echo "<script>alert('Codigo de Cliente Invalido');</script>"; echo $volta; exit;
    }
    $sql = "select *from aclientes where ccodigo = $cod";
    $exsql = pg_query($conc,$sql);
    $rssql = pg_fetch_array($exsql);
    $codi = $rssql['ccodigo'];
    if ($codi == null) {
        echo "<script>alert('A Busca nao retornou nenhum cliente com o cod. informado :$cod');</script>"; echo $volta; exit;
    }
    $nome = $rssql['cnomecliente'];
    $cpf = $rssql['ccpf'];
   
}
if ($tipo == 'CPF') {
    $cpf = $_POST['ccpf'];
    if ($cpf == null) {
        echo "<script>alert('CPF de Cliente Invalido');</script>"; echo $volta; exit;
    }
    $cpf = soNumero($cpf);
    if(strlen($cpf)> 11 or strlen($cpf)< 11){
        echo "<script>alert('CPF de Cliente Invalido: $cpf');</script>"; echo $volta; exit;
    }    
    $sql = "select *from aclientes where ccpf = '$cpf'"; 
    $exsql = pg_query($conc,$sql);
    $rssql = pg_fetch_array($exsql);
    $codi = $rssql['ccodigo'];
    if ($codi == null) {
        $sql = "select *from tidas where cpf = '$cpf'";
        $exsql = pg_query($serv,$sql);
        $rssql = pg_fetch_array($exsql);
        $ccpf = $rssql['cpf'];
        if ($ccpf == null) {
            echo "<script>alert('A Busca nao retornou nenhum cliente com o Cpf informado :$cpf');</script>"; echo $volta; exit;
        } else {
            $codi = 'Tidas';
            $nome = $rssql['nome'];            
        }       
    } else {
        $codi = $rssql['ccodigo'];
        $nome = $rssql['cnomecliente'];
        $cpf = $rssql['ccpf'];
    }
}
$arrumacpf = formatar_cpf_cnpj($cpf);
echo "<table border='2' width='100%' bgcolor=#F5F6CE >";
echo "<tr><td><font size=3><strong>Codigo: $codi</strong></font></td>"."<td><font color=\"black\" size=3><strong>Nome: $nome </strong></font></td>".
    "<td><font color=\"black\" size=3><strong>Cpf: $arrumacpf </strong></font></td>"."</tr>";
echo "</table>";
if ($codi <> 'Tidas') {
    $sql = "select *from asduplicatas where  cclidupli = $codi and cdpadupli is null order by cvendupli  ";
    $exsql=pg_query($conc,$sql);
    while ($row = pg_fetch_assoc($exsql)) {
        $nf = $row['cnotdupli'];
        $valor = $row['cvprdupli'];
        $venci = $row['cvendupli'];
        $parc = $row['cnprdupli'];
        $emp = $row['cempdupli'];
        $com = "insert into parcelas values($nf,$valor,$parc,'$venci',$codi,'$cpf','C',$emp)"; 
        $excom=pg_query($serv,$com);
    }
    $exsql=pg_query($conv,$sql);
    while ($row = pg_fetch_assoc($exsql)) {
        $nf = $row['cnotdupli'];
        $valor = $row['cvprdupli'];
        $venci = $row['cvendupli'];
        $parc = $row['cnprdupli'];
        $emp = $row['cempdupli'];
        $com = "insert into parcelas values($nf,$valor,$parc,'$venci',$codi,'$cpf','V',$emp)";
        $excom=pg_query($serv,$com);
    }
    $exsql=pg_query($conj,$sql);
    while ($row = pg_fetch_assoc($exsql)) {
        $nf = $row['cnotdupli'];
        $valor = $row['cvprdupli'];
        $venci = $row['cvendupli'];
        $parc = $row['cnprdupli'];
        $emp = $row['cempdupli'];
        $com = "insert into parcelas values($nf,$valor,$parc,'$venci',$codi,'$cpf','J',$emp)";
        $excom=pg_query($serv,$com);
    }
    $sql = "select *from parcelatidas where  cpf = '$cpf'  order by vencimento  ";
    $exsql=pg_query($serv,$sql);
    while ($row = pg_fetch_assoc($exsql)) {
        $nf = $row['nfe'];
        $valor = $row['valor'];
        $venci = $row['vencimento'];
        $parc = $row['numero'];        
        $emp = '0';
        $com = "insert into parcelas values($nf,$valor,$parc,'$venci',$codi,'$cpf','T',$emp)";
        $excom=pg_query($serv,$com);
    }
    $sql = "select *from parcelas where cpf = '$cpf' order by vencimento ";
    $exsql=pg_query($serv,$sql);
    $rssql = pg_fetch_array($exsql);
    $nf = $rssql['nfe'];
    if ($nf == null) {
        echo "<p style=background:#000000; align=center <br/><b><font size=5 color=#7CFC00>Nenhuma Parcela Retornou da Busca</font></b></p>";
        exit;
    }
    $venci = $rssql['vencimento'];
    $diferenca = strtotime($hoje) - strtotime($venci);
    $dias = floor($diferenca / (60 * 60 * 24));
    if ($dias >= 90) {
        echo "<p style=background:#F5F6CE; align=center <br/><b><font size=5 color=red>Cliente com Parcelas Vencidas a Mais <br> de: $dias Dias
                    Para Consultar Valores Entrar em Contato com o Crediario </font></b></p>";
        ?>
        <!DOCTYPE html>
        <html>
        <head>
        <link rel="stylesheet" href="css/style.css"></link>
        <center><form name = "form1" method= "post" action= "index.php"></center>
        <br><br>
        <center>
        </center>
        <br><br>
        <center><input class="btn btn-red"  type="submit"  value="Voltar"></center>
        <br><br>
        </form>
        </head>
        </html>
        <?php header("Content-Type: text/html; charset=ISO-8859-1",true);
        exit;
        
    }
    
    $cac = 0;
    $civ = 0;
    $vid = 0;
    $tid = 0;
    $ttmes = 0.00;
    $ttjuromes = 0.00;
    $ttmesatu = 0.00;
    $tidas = 0.00;
    echo "<table border='2' width='100%' bgcolor=#FFFFFF >";
    echo "<tr><td><font size=3><strong>Empresa</strong></font></td>"."<td><font color=\"black\" size=3><strong>N. Parcela</strong></font></td>"
            ."<td><font color=\"black\" size=3><strong>Vencimento</strong></font></td>"."<td><font color=\"black\" size=3><strong>Valor</strong></font></td>".
            "<td><font color=\"black\" size=3><strong>Juro</strong></font></td>"."<td><font color=\"black\" size=3><strong>Valor Atualizado</strong></font></td>"."</tr>";
    $sql = "select extract(month from vencimento)as mes ,extract(year from vencimento)  as ano from parcelas where cpf = '$cpf'  
            group by ano,mes
            order by ano,mes";
    $exsql=pg_query($serv,$sql);
    while ($row = pg_fetch_assoc($exsql)) {
        $ini = 1;
        $cor1 = "#D3D3D3";
        $cor2 = "#FDF5E6";
        $ano = $row['ano'];
        $mes = $row['mes'];
        $mesano = $ano.'-'.$mes;
        $com = "select  *from parcelas where cpf = '$cpf'
                and extract(year from vencimento) ||'-'|| extract(month  from vencimento) = '$mesano' order by vencimento"; 
        $excom=pg_query($serv,$com);
        $mes = 0.00;
        
        $juromes = 0.00;
        $mesatu = 0.00;
        while ($roww = pg_fetch_assoc($excom)) {
            if ($ini%2 == 0){
                $cor = $cor1;
            } else {
                $cor = $cor2;
            }
            $valor = $roww['valor'];
            $mes += $valor;
            $venci = $roww['vencimento'];
            
            $emp = $roww['loja'];
            $base = $roww['base'];
            if ($base == 'C') {
                $cac ++;
                if ($emp == 1 or $emp == 2) {
                    $emp = 'Confec. Parte Baixa';
                } elseif ($emp == 3 or $emp == 4){
                    $emp = 'Shop Masp Cdr';
                } elseif ($emp == 5 or $emp == 6){
                    $emp = 'Calc. Parte Alta';
                } elseif ($emp == 7 or $emp == 8){
                    $emp = 'Calc. Parte Baixa';
                }
                
            } elseif ($base == 'V'){
                $vid ++;
                if ($emp == 13 or $emp == 14) {
                    $emp = 'Videira';
                } elseif ($emp == 15 or $emp == 16){
                    $emp = 'Martello';
                } elseif ($emp == 17 or $emp == 18){
                    $emp = 'Shop Masp Vd.';
                }
            } elseif ($base == 'J'){
                $civ ++;
                if ($emp == 1 or $emp == 2) {
                    $emp = 'Atacadao';
                } elseif ($emp == 3 or $emp == 4){
                    $emp = 'Confc. Parte Alta';
                }
            } elseif ($base == 'T'){
                $emp = 'Tidas';
                $tid ++;
            }
            if ($emp == 'Tidas') {
                $cor = "#32CD32";
                $ini --;
            }            
            if ($emp <> 'Tidas') {
                $carencia = date('Y-m-d', strtotime($venci. '+5 days'));
                if ($hoje > $carencia) {
                    $diferenca = strtotime($hoje) - strtotime($venci);
                    $dias = floor($diferenca / (60 * 60 * 24));
                    $multa = $valor*0.02;
                    $juro = $valor*((0.0534*$dias)/100);
                    $juro +=$multa;
                    $atulizado = $valor+$juro;
                    $juromes += $juro;
                    $mesatu += $atulizado;
                }
                else {
                    $juro =0.00;
                    $mesatu += $valor;
                    $atulizado = $valor;
                }
                
            } else {
                $carencia = date('Y-m-d', strtotime($venci. '+3 days'));
                if ($hoje > $carencia) {
                    $diferenca = strtotime($hoje) - strtotime($venci);
                    $dias = floor($diferenca / (60 * 60 * 24));
                    $multa = $valor*0.02;
                    $juro = $valor*((0.48*$dias)/100);
                    $juro +=$multa;
                    $atulizado = $valor+$juro;
                    $juromes += $juro;
                    $mesatu += $atulizado;
                    
                } else {
                    $atulizado = $valor;
                    $juro =0.00;
                    $mesatu += $valor;
                }
                $tidas += $valor;
                
            }
            $venci = implode("/",array_reverse(explode("-",$venci)));
            echo  "<td bgcolor=$cor>".$emp."</font></td>\n";
            echo  "<td bgcolor=$cor>".$roww['parcela']."</font></td>\n";
            echo  "<td bgcolor=$cor>".$venci."</font></td>\n";
            echo  "<td bgcolor=$cor>".number_format($valor,2,",",".")."</font></td>\n";
            echo  "<td bgcolor=$cor>".number_format($juro,2,",",".")."</font></td>\n";
            echo  "<td bgcolor=$cor>".number_format($atulizado,2,",",".")."</font></td>\n";
            echo "</tr>\n";
            $ini ++;
        }
        $ttmes += $mes;
        $ttjuromes += $juromes;
        $ttmesatu += $mesatu;
        echo "<td bgcolor = #FF6347 ><font size=4><strong>".'TT'."</strong></font></td>\n";
        echo "<td bgcolor = #FF6347 ><font size=4><strong>".''."</strong></font></td>\n";
        echo "<td bgcolor = #FF6347 ><font size=4><strong>".''."</strong></font></td>\n";
        echo "<td bgcolor = #FF6347 ><font size=4><strong>".number_format($mes,2,",",".")."</strong></font></td>\n";
        echo "<td bgcolor = #FF6347 ><font size=4><strong>".number_format($juromes,2,",",".")."</strong></font></td>\n";
        echo "<td bgcolor = #FF6347 ><font size=4><strong>".number_format($mesatu,2,",",".")."</strong></font></td>\n";
        echo "</tr>\n";
        
    }
    $ttmes -= $tidas;
    echo "<td bgcolor = #FFFF00 ><font size=4><strong>".'TT'."</strong></font></td>\n";
    echo "<td bgcolor = #FFFF00 ><font size=4><strong>".''."</strong></font></td>\n";
    echo "<td bgcolor = #00FF00 ><font size=4><strong>".'TT Tidas: '.number_format($tidas,2,",",".")."</strong></font></td>\n";
    echo "<td bgcolor = #FFFF00 ><font size=4><strong>".'TT Loja : '.number_format($ttmes,2,",",".")."</strong></font></td>\n";
    echo "<td bgcolor = #FFFF00 ><font size=4><strong>".number_format($ttjuromes,2,",",".")."</strong></font></td>\n";
    echo "<td bgcolor = #FFFF00 ><font size=4><strong>".'Loja+Juro+Tidas:'.number_format($ttmesatu,2,",",".")."</strong></font></td>\n";
    echo "</tr>\n";
    $sql = "rollback";
    $exsql=pg_query($serv,$sql);
    if ($cac > 0) {
        echo "<p style=background:#F5F6CE; align=center <br/><b><font size=4 color=red>Percela Sistema Cacador</font></b></p>";
    }
    if ($vid >0) {
        echo "<p style=background:#F5F6CE; align=center <br/><b><font size=4 color=red>Percela Sistema Videira</font></b></p>";
    }
    if ($civ >0) {
        echo "<p style=background:#F5F6CE; align=center <br/><b><font size=4 color=red>Percela Sistema Apolo/Atacadao</font></b></p>";
    }
    if ($tid >0) {
        echo "<p style=background:#F5F6CE; align=center <br/><b><font size=4 color=red>Percela Sistema Tidas</font></b></p>";
    }
    
    echo "</table>";   
}
//<font color = > 
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/style.css"></link>
<center><form name = "form1" method= "post" action= "index.php"></center>
<br><br>
<center>
</center>
<br><br>
<center><input class="btn btn-red"  type="submit"  value="Voltar"></center>
<br><br>
</form>
</head>
</html>