<?
session_start();
/*
 * verifica se houve login e tamb�m regras para outras verifica��es (ex: permiss�es do usu�rio)!
 */
if(!isset($_SESSION['id_usuario'])) 
  die('Acesso negado (Access denied)!');
else { // Inserir regras para outras verifica��es (ex: permiss�es do usu�rio)!
}

//Mostrar computadores baseados no tipo de pesquisa solicitada pelo usu�rio
require_once('../include/library.php');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?=$oTranslator->_('Relatorio de Softwares Inventariados por Maquinas');?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>

<body bgcolor="#FFFFFF" topmargin="5">
<table border="0" align="left" cellpadding="0" cellspacing="0" bordercolor="#999999">
  <tr bgcolor="#E1E1E1"> 
    <td rowspan="5" bgcolor="#FFFFFF"><img src="../imgs/cacic_novo.gif" width="50" height="50"></td>
    <td rowspan="5" bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr bgcolor="#E1E1E1"> 
    <td nowrap bgcolor="#FFFFFF">
    	<font color="#333333" size="4" face="Verdana, Arial, Helvetica, sans-serif">
    		<strong>
    		CACIC - <?=$oTranslator->_('Relatorio de Cadastros Inconsistentes');?>
    		</strong>
    	</font>
    </td>
  </tr>
  <tr> 
    <td height="1" bgcolor="#333333"></td>
  </tr>
  <tr> 
    <td><p align="left"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">
    	<?=$oTranslator->_('Gerado em');?> <? echo date("d/m/Y �\s H:i"); ?></font></p></td>
  </tr>
</table>
<br>
<br>
<br>
<br>
<?
conecta_bd_cacic();
$linha = '<tr bgcolor="#e7e7e7"> 
			  <td height="1"></td>
			  <td height="1"></td>
         </tr>';
?>
<?
	 $query = "SELECT nr_patrimonio 
		   FROM (SELECT nr_patrimonio, nm_computador, count(*) 
			 FROM softwares_estacao 
			 WHERE (dt_desinstalacao IS NULL) 
			 GROUP BY nr_patrimonio, nm_computador) as temp 
		   GROUP BY nr_patrimonio HAVING count(*) > 1";

	$result = mysql_query($query) or die($oTranslator->_('kciq_msg select on table fail', array('softwares_estacao'))."! ".$oTranslator->_('kciq_msg session fail',false,true));

	 $query2 = "SELECT nm_computador 
		   FROM (SELECT nr_patrimonio, nm_computador, count(*) 
			 FROM softwares_estacao 
			 WHERE (dt_desinstalacao IS NULL) 
			 GROUP BY nr_patrimonio, nm_computador) as temp 
		   GROUP BY nm_computador HAVING count(*) > 1";

	$result2 = mysql_query($query2) or die($oTranslator->_('kciq_msg select on table fail', array('softwares_estacao'))."! ".$oTranslator->_('kciq_msg session fail',false,true));

	 $queryEmBranco = "SELECT DISTINCT nr_patrimonio 
			   FROM softwares_estacao 
			   WHERE (dt_desinstalacao IS NULL) AND 
				 (nm_computador IS NULL) 
			   ORDER BY nr_patrimonio 
			   LIMIT 500";

	$resultEmBranco = mysql_query($queryEmBranco) or die($oTranslator->_('kciq_msg select on table fail', array('softwares_estacao'))."! ".$oTranslator->_('kciq_msg session fail',false,true));

?>
<table border="0" align="center" cellpadding="0" cellspacing="1">
  <tr> 
    <td align="center" nowrap></td>
  </tr>
  <tr> 
    <td height="1" bgcolor="#333333"></td>
  </tr>
  <tr> 
    <td> <table border="0" cellpadding="2" cellspacing="0" bordercolor="#333333" align="center">
        <tr bgcolor="#E1E1E1"> 
          <td align="center"  nowrap>&nbsp;</td>
          <td align="center"  nowrap><div align="left"><strong></strong></div></td>
          <td align="center"  nowrap>&nbsp;</td>
          <td align="center"  nowrap bgcolor="#E1E1E1"><div align="center"><strong><font color="#333333" size="2" face="Verdana, Arial, Helvetica, sans-serif"><?=$oTranslator->_('Patrimonio');?></font></strong></div></td>
          <td nowrap >&nbsp;</td>
        </tr>
        <?  
	$Cor = 0;
	$NumRegistro = 1;
	
	while($row = mysql_fetch_array($result)) {
		  
	 ?>
        <tr <? if ($Cor) { echo 'bgcolor="#E1E1E1"'; } ?>> 
          <td nowrap>&nbsp;</td>
          <td nowrap><div align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><? echo $NumRegistro; ?></font></div></td>
          <td nowrap>&nbsp;</td>
	  <td nowrap><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><? echo $row['nr_patrimonio']; ?></font></div></td>
	  <td nowrap>&nbsp;</td>
          <? 
	$Cor=!$Cor;
	$NumRegistro++;
	}
	while($row = mysql_fetch_array($result2)) {
		  
	 ?>
        <tr <? if ($Cor) { echo 'bgcolor="#E1E1E1"'; } ?>> 
          <td nowrap>&nbsp;</td>
          <td nowrap><div align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><? echo $NumRegistro; ?></font></div></td>
          <td nowrap>&nbsp;</td>
	  <td nowrap><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><? echo $row['nm_computador']; ?></font></div></td>
	  <td nowrap>&nbsp;</td>
          <? 
	$Cor=!$Cor;
	$NumRegistro++;
	}
	
	while($row = mysql_fetch_array($resultEmBranco)) {
		  
	 ?>
        <tr <? if ($Cor) { echo 'bgcolor="#E1E1E1"'; } ?>> 
          <td nowrap>&nbsp;</td>
          <td nowrap><div align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><? echo $NumRegistro; ?></font></div></td>
          <td nowrap>&nbsp;</td>
	  <td nowrap><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><? echo $row['nr_patrimonio']; ?></font></div></td>
	  <td nowrap>&nbsp;</td>
          <? 
	$Cor=!$Cor;
	$NumRegistro++;
	}

?>
      </table></td>
  </tr>
  <tr> 
    <td height="1" bgcolor="#333333"></td>
  </tr>
  <tr> 
    <td height="10"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font></td>
  </tr>
</table>
<p align="center">
  <font size="1" face="Verdana, Arial, Helvetica, sans-serif">
	<?=$oTranslator->_('Gerado por');?>
	<strong>CACIC</strong> - Configurador Autom&aacute;tico e Coletor de Informa&ccedil;&otilde;es Computacionais
  </font><br>
  <font size="1" face="Verdana, Arial, Helvetica, sans-serif">
  Software desenvolvido pela Dataprev - Escrit&oacute;rio do Esp&iacute;rito Santo</font></p>	
</body>
</html>