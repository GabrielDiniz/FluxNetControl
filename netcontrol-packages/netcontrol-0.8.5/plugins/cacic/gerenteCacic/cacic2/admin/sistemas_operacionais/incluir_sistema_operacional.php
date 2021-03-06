<?
 /* 
 Copyright 2000, 2001, 2002, 2003, 2004, 2005 Dataprev - Empresa de Tecnologia e Informa��es da Previd�ncia Social, Brasil

 Este arquivo � parte do programa CACIC - Configurador Autom�tico e Coletor de Informa��es Computacionais

 O CACIC � um software livre; voc� pode redistribui-lo e/ou modifica-lo dentro dos termos da Licen�a P�blica Geral GNU como 
 publicada pela Funda��o do Software Livre (FSF); na vers�o 2 da Licen�a, ou (na sua opni�o) qualquer vers�o.

 Este programa � distribuido na esperan�a que possa ser  util, mas SEM NENHUMA GARANTIA; sem uma garantia implicita de ADEQUA��O a qualquer
 MERCADO ou APLICA��O EM PARTICULAR. Veja a Licen�a P�blica Geral GNU para maiores detalhes.

 Voc� deve ter recebido uma c�pia da Licen�a P�blica Geral GNU, sob o t�tulo "LICENCA.txt", junto com este programa, se n�o, escreva para a Funda��o do Software
 Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
session_start();
/*
 * verifica se houve login e tamb�m regras para outras verifica��es (ex: permiss�es do usu�rio)!
 */
if(!isset($_SESSION['id_usuario'])) 
  die('Acesso restrito (Restricted access)!');
else { // Inserir regras para outras verifica��es (ex: permiss�es do usu�rio)!
}

include_once "../../include/library.php";
AntiSpy();
if($_REQUEST['submit']) 
{
	Conecta_bd_cacic();
	
	$query = "SELECT 	* 
			  FROM 		so 
			  WHERE 	".($_REQUEST['frm_te_so'] <>''?"te_so = '".$_REQUEST['frm_te_so']."' OR ":""). 
			            "sg_so = '".$_REQUEST['frm_sg_so']."'";
	$result = mysql_query($query) or die ('Select so falhou ou sua sess�o expirou!');
	if (mysql_num_rows($result) > 0) 
		{
		header ("Location: ../../include/registro_ja_existente.php?chamador=../admin/sistemas_operacionais/incluir_sistema_operacional.php&tempo=1");									 							
		}
	else 
		{
		$query = "INSERT 
				  INTO 		so 
				  			(id_so,
							 te_desc_so, 
							 sg_so, 
							 te_so,
							 in_mswindows) 
				 VALUES 	(".	$_REQUEST['frm_id_so'].",'".
				 				$_REQUEST['frm_te_desc_so']."','".
				 				$_REQUEST['frm_sg_so']."','".
								$_REQUEST['frm_te_so']."','".
								$_REQUEST['frm_in_mswindows']."')"; 
		$result = mysql_query($query) or die ('Insert so falhou ou sua sess�o expirou!');
		GravaLog('INS',$_SERVER['SCRIPT_NAME'],'so');

		header ("Location: ../../include/operacao_ok.php?chamador=../admin/sistemas_operacionais/index.php&tempo=1");									 						
		}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<?
}
else 
{
?>
<head>
<link rel="stylesheet"   type="text/css" href="../../include/cacic.css">
<title>Inclus&atilde;o de Sistema Operacional</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT LANGUAGE="JavaScript">
	
function valida_form() 
	{
	if ( document.form.frm_te_desc_so.value == "" ) 
		{	
		alert("A descri��o do Sistema Operacional � obrigat�ria.");
		document.form.frm_te_desc_so.focus();
		return false;
		}
	else if ( document.form.frm_sg_so.value == "" ) 
		{	
		alert("A sigla do Sistema Operacional � obrigat�ria.");
		document.form.frm_sg_so.focus();
		return false;
		}
	else if ( document.form.frm_te_so.value == "" ) 
		{	
		alert("A identifica��o interna do Sistema Operacional � obrigat�ria.");
		document.form.frm_te_so.focus();
		return false;
		}
		
	return true;
	}
</script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
</head>

<body background="../../imgs/linha_v.gif" onLoad="SetaCampo('frm_te_desc_so')">
<script language="JavaScript" type="text/javascript" src="../../include/cacic.js"></script>
<table width="90%" border="0" align="center">
  <tr> 
    <td class="cabecalho">Inclus&atilde;o de Novo Sistema Operacional</td>
  </tr>
  <tr> 
    <td class="descricao">As informa&ccedil;&otilde;es abaixo referem-se a um 
      sistema operacional instalado em parque computacional inventariado pelo 
      CACIC, onde a ID Interna refere-se ao valor enviado pelo Gerente de Coletas (ger_cols.exe), composto por <strong>platformId</strong>, <strong>majorVer</strong>, <strong>minorVer</strong> e <strong>CSDVersion</strong>.</td>
  </tr>
</table>
<form method="post" ENCTYPE="multipart/form-data" name="form">
  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="1">
    <tr> 
      <td class="label"><br>
        Descri��o:</td>
      <td class="label">Sigla:</td>
    </tr>
    <tr> 
      <td height="1" bgcolor="#333333"></td>
      <td bgcolor="#333333"></td>
    </tr>
    <tr> 
      <td><input name="frm_te_desc_so" type="text" id="frm_te_desc_so" size="50" maxlength="50"  class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" > 
      </td>
      <td><input name="frm_sg_so" type="text" id="frm_sg_so" size="20" maxlength="20" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" ></td>
    </tr>
    <tr> 
      <td class="label">&nbsp;</td>
      <td class="label">&nbsp;</td>
    </tr>
    <tr> 
      <td class="label"><div align="left">ID Interna:</div></td>
      <td class="label">ID Externa:</td>
    </tr>
    <tr> 
      <td height="1" bgcolor="#333333"></td>
      <td bgcolor="#333333"></td>
    </tr>
	<tr> 
	<td nowrap><input name="frm_te_so" type="text" id="frm_te_so" size="50" maxlength="50" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);"></td>
      <td nowrap><input name="frm_id_so" type="text" class="normal" id="frm_id_so" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" size="50" maxlength="11"></td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td>
      <td nowrap>&nbsp;</td>
    </tr>
    <tr> 
      <td height="1" bgcolor="#333333"></td>
      <td bgcolor="#333333"></td>
    </tr>
	
    <tr>
      <td nowrap class="label"><div align="left"><input type="checkbox" name="frm_in_mswindows" id="frm_in_mswindows" value="S" <? if ($row['in_mswindows']=='S') echo 'checked';?>>
      Sistema Operacional MS-Windows</div></td>
      <td nowrap>&nbsp;</td>
    </tr>

  </table>
  <p align="center"> 
    <input name="submit" type="submit" value="  Gravar Informa&ccedil;&otilde;es  "  onClick="return valida_form();return Confirma('Confirma Inclus�o de Sistema Operacional?');">
  </p>
</form>
<p>
  <?
}
?>
</p>
</body>
</html>
