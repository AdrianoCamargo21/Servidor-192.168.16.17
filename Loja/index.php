<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Consulda de Parcelas</title>
<link rel="stylesheet" href="css/style.css"></link>
<center>
<img src="img/fundo.jpg" alt="10" heigth="100px"width="400px">
<table width="100%" cellspacing="1" cellpadding="3" border="0"bgcolor="#ACFA58">
<tr>
<br>
<td><font color="Black" face="arial, verdana, helvetica">
<center><h1><font face="Arial" color="black">Consulta de Parcelas</font></h1></center>
<form name="form1" method="post" action="parcela.php">
<script language="JavaScript1.2">
		<!--
		var ns6=document.getElementById&&!document.all?1:0
		var head="display:''"
		var folder=''
		function expandit(curobj){
		folder=ns6?curobj.nextSibling.nextSibling.style:document.all[curobj.sourceIndex+1].style
		if (folder.display=="none")
		folder.display=""
		else
		folder.display="none"
		}
//-->
function fMasc(objeto,mascara) {
				obj=objeto
				masc=mascara
				setTimeout("fMascEx()",1)
			}
			function fMascEx() {
				obj.value=masc(obj.value)
			}
function mCPF(cpf){
	cpf=cpf.replace(/\D/g,"")
	cpf=cpf.replace(/(\d{3})(\d)/,"$1.$2")
	cpf=cpf.replace(/(\d{3})(\d)/,"$1.$2")
	cpf=cpf.replace(/(\d{3})(\d{1,2})$/,"$1-$2")
	return cpf
}
</script>
<center>

<input type="radio" name="tipo" value="CO" onClick="expandit(this)">Consulta Por Código
<span style="display:none" style=&{head};>
<br>
Código:
<input id="C" name= "C"  min="1" type="number" size ="4" max = "99999" >
<br>
</span>
<input type="radio" name="tipo" value="CPF" onClick="expandit(this)">Consulta Por Cpf
<span style="display:none" style=&{head};>
<br>
Cpf:
<input type="text" name="ccpf" onkeydown="javascript: fMasc( this, mCPF );">
<br>
</span>
</center>
<br>
<center><input class="btn btn-green" type="submit"
value="ENVIAR" /> <input class="btn btn-red" type="reset"
value="Cancelar" /></center>
</form>
</font>
</td>
</tr>
</table>
</center>
</head>
</html>