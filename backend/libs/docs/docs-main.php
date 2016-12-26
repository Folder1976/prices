<?php
defined('SHP_VALID') or die('Direct Access is not allowed.');


switch ($ModAct) {
	case "":
		echo "<h3>Зарегистированные документы:</h3>
		<p><table border=1 cellspacing=0 cellpadding=3 style=\"width: 1000px;\" align=center>
		<tr bgcolor=silver align=center>
		<td><b>#</b></td>
		<td><b>Название</b></td>
		<td><b>File</b></td>
		<td><b>File Date</b></td>
		<td><b>Edit</b></td>
		<td><b>Del</b></td>
		</tr>
		<tr bgcolor=yellow align=center><td colspan=6><a href=\"".$ModURL."&modact=addnewdoc\">Добавить новый шаблон документа</a></td></tr>";

		$rs = mysql_query("SELECT DocID, DocNazv, DocFile
		FROM ".SQLPRFX." WHERE 1;", $hlnk) or die ("GetAll");
		$i = 1;
		while ($docsDT = mysql_fetch_array($rs)) {
			$tFl = $FlUp = "&nbsp;";
			if ($docsDT["DocFile"] != "" && file_exists($SPUrl."docs/".$docsDT["DocFile"])) {
				$tFl = $docsDT["DocFile"];
				$FlUp = date("d.m.Y", filemtime($SPUrl."docs/".$docsDT["DocFile"]));
			}
			echo "<tr>
			<td>".$i."</td>
			<td>".$docsDT["DocNazv"]."</td>
			<td>".$tFl."</td>
			<td align=center>".$FlUp."</td>
			<td align=center><a href=\"".$ModURL."&modact=editdoc&docid=".$docsDT["DocID"]."\">Edit</a></td>
			<td align=center><a href=\"".$ModURL."&modact=delfulldoc&docid=".$docsDT["DocID"]."\" ONCLICK=\"javascript:if(confirm('Действительно хотите удалить документ?\\nЭто действие необратимо!')) {return true;} else{return false;}\">Del</a></td>
			</tr>";
			$i += 1;
		}
		echo "</table>";
	break;

	case "addnewdoc":
		echo "Добавление нового документа
		<p><FORM NAME=\"u2\" ACTION=\"".$ModURL."&modact=savenewdoc\" enctype=\"multipart/form-data\" METHOD=POST>
		<table border=1 cellspacing=0 cellpadding=3 style=\"width: 1000px;\">
		<tr><td bgcolor=silver align=center><b>Название документа</b></td><td><input type=text name=\"docnazv\" size=60></td></tr>
		<tr><td bgcolor=silver align=center><b>Файл с документом</b></td><td><input name=\"strctimp\" type=\"file\" size=50></td></tr>
		<tr><td bgcolor=silver align=center><b>Поля с данными</b></td><td>
			<table border=1 cellspacing=0 cellpadding=3 width=100%>
			<tr bgcolor=silver align=center>
			<td><b>#</b></td>
			<td><b>Название</b></td>
			<td><b>Адрес ячейки</b></td>
			<td><b>Данные из заказа</b></td>
			</tr>\n";
			for($i=1; $i<=3; $i++) {
				echo "<tr bgcolor=yellow align=center>
				<td>N".$i."</td>
				<td><input type=text name=\"ndtnazv".$i."\" size=40></td>
				<td><input type=text name=\"ndtaddr".$i."\" size=10></td>
				<td><input type=text name=\"ndtdata".$i."\" size=40></td>
				</tr>\n";
			}
		echo "</table>
		</td></tr>
		<tr><td bgcolor=silver align=center><b>Строка с товаром:<br>перед какой строкой вставлять</b></td><td><input type=text name=\"lineins\" size=20></td></tr>

		<tr><td bgcolor=silver align=center><b>Строка с товаром: объединения ячеек</b></td><td>
			<table border=1 cellspacing=0 cellpadding=3 width=100%>
			<tr bgcolor=silver align=center>
			<td><b>#</b></td>
			<td><b>С ячейки</b></td>
			<td><b>По ячейку</b></td>
			</tr>\n";
			for($i=1; $i<=3; $i++) {
				echo "<tr bgcolor=yellow align=centser>
				<td>N".$i."</td>
				<td><input type=text name=\"nmrgfrom".$i."\" size=10></td>
				<td><input type=text name=\"nmrgto".$i."\" size=10></td>
				</tr>\n";
			}
		echo "</table></td></tr>
		<tr><td bgcolor=silver align=center><b>Строка с товаром: данные</b></td><td>
			<table border=1 cellspacing=0 cellpadding=3 width=100%>
			<tr bgcolor=silver align=center>
			<td><b>#</b></td>
			<td><b>Название</b></td>
			<td><b>Адрес ячейки</b></td>
			<td><b>Данные по товару</b></td>
			<td><b>Выравнивание</b></td>
			<td><b>Формат</b></td>
			</tr>\n";
			for($i=1; $i<=3; $i++) {
				echo "<tr bgcolor=yellow align=center>
				<td>N".$i."</td>
				<td><input type=text name=\"nzklinenazv".$i."\" size=40></td>
				<td><input type=text name=\"nzklineaddr".$i."\" size=10></td>
				<td><input type=text name=\"nzklinedata".$i."\" size=40></td>
				<td><select name=\"nzkalign".$i."\">";
				foreach($DocAlign as $id => $Params) {
					echo "<option value=\"".$id."\">".$Params[0]."</option>";
				}
				echo "</select></td>
				<td><input type=text name=\"nzklineformat".$i."\" size=10></td>
				</tr>\n";
			}
		echo "</table>
		</td></tr>
		<tr><td colspan=2 align=center><input type=submit value=\"Добавить\"></td></tr>
		</table>
		</form>";
	break;

	case "savenewdoc":
		$FName = "";
		if (isset($_FILES['strctimp']['tmp_name']) && $_FILES['strctimp']['tmp_name'] != "") {
			$FName = strtolower($instances["textfunct"]->translite($_FILES['strctimp']['name']));
			@move_uploaded_file($_FILES['strctimp']['tmp_name'], $SPUrl."docs/".$FName);
		}

		$DocNazv = str_replace(array("'", '"'), array('', '&quot;'),  $_POST["docnazv"]);

		$Fields = "";
		for($i=1; $i<=3; $i++) {
			if ($_POST["ndtaddr".$i] != "" && $_POST["ndtdata".$i] != "") {
				$tNazv = str_replace(array("'", '"'), array('', '&quot;'),  $_POST["ndtnazv".$i]);
				$tAddr = str_replace(array("'", '"'), array('', '&quot;'),  $_POST["ndtaddr".$i]);
				$tData = str_replace(array("'", '"'), array('', '&quot;'),  $_POST["ndtdata".$i]);
				if ($Fields != "") {$Fields .= "@";}
				$Fields .= $tNazv.'%'.$tAddr.'%'.$tData;
			}
		}

		$LineBeforIns = str_replace(array("'", '"'), array('', '&quot;'),  $_POST["lineins"]);

		$ZKLNMerge = "";
		for($i=1; $i<=3; $i++) {
			if ($_POST["nmrgfrom".$i] != "" && $_POST["nmrgto".$i] != "") {
				$tFrom = str_replace(array("'", '"'), array('', '&quot;'),  $_POST["nmrgfrom".$i]);
				$tTo = str_replace(array("'", '"'), array('', '&quot;'),  $_POST["nmrgto".$i]);
				if ($ZKLNMerge != "") {$ZKLNMerge .= "@";}
				$ZKLNMerge .= $tFrom.'%'.$tTo;
			}
		}

		$ZKLNData = "";
		for($i=1; $i<=3; $i++) {
			if ($_POST["nzklineaddr".$i] != "" && $_POST["nzklinedata".$i] != "") {
				$tNazv = str_replace(array("'", '"'), array('', '&quot;'),  $_POST["nzklinenazv".$i]);
				$tAddr = str_replace(array("'", '"'), array('', '&quot;'),  $_POST["nzklineaddr".$i]);
				$tData = str_replace(array("'", '"'), array('', '&quot;'),  $_POST["nzklinedata".$i]);
				$tAlign = str_replace(array("'", '"'), array('', '&quot;'),  $_POST["nzkalign".$i]);
				$tFormat = str_replace(array("'", '"'), array('', '&quot;'),  $_POST["nzklineformat".$i]);

				if ($ZKLNData != "") {$ZKLNData .= "@";}
				$ZKLNData .= $tNazv.'%'.$tAddr.'%'.$tData.'%'.$tAlign.'%'.$tFormat;
			}
		}

		$r=mysql_query("INSERT INTO ".SQLPRFX."
		(DocID, DocNazv, DocFile, DataFieldsArr, DataLineInsBefore, DataLineMerge, DataLineValues)
		 VALUES ('', '".$DocNazv."', '".$FName."', '".$Fields."', '".$LineBeforIns."', '".$ZKLNMerge."', '".$ZKLNData."');", $hlnk) or die ("Addon :(");
		$DocNewID = mysql_insert_id($hlnk);

		echo "<H2>Добавлено!</H2><SCRIPT>\n\nvar i = setTimeout(\"window.location.href='".$ModURL."&modact=editdoc&docid=".$DocNewID."'\", 200);\n</SCRIPT>";
	break;

	case "editdoc":
		if (!isset($_GET["docid"]) || !is_numeric($_GET["docid"])) {die("<SCRIPT>history.back();</SCRIPT>");}
		$DocID = $_GET["docid"];

		$r = mysql_query("SELECT DocNazv, DocFile, DataFieldsArr, DataLineInsBefore, DataLineMerge, DataLineValues
		FROM ".SQLPRFX." WHERE DocID='".$DocID."';", $hlnk) or die ("GetDocl");
		$DocDat = mysql_fetch_array($r);

		echo "Редактирование документа
		<p><FORM NAME=\"u2\" ACTION=\"".$ModURL."&modact=savechngdoc&docid=".$DocID."\" enctype=\"multipart/form-data\" METHOD=POST>
		<table border=1 cellspacing=0 cellpadding=3 style=\"width: 1000px;\">
		<tr><td bgcolor=silver align=center><b>Название документа</b></td><td><input type=text name=\"docnazv\" size=60 value=\"".$DocDat["DocNazv"]."\"></td></tr>
		<tr><td bgcolor=silver align=center><b>Файл с документом</b></td><td>";
		if ($DocDat["DocFile"] == "") {echo "<INPUT TYPE=file NAME=\"strctimp\" size=50>";}
		else {
			echo $DocDat["DocFile"]."
			<BR><A HREF=\"".$ModURL."&modact=deldoc&docid=".$DocID."\" ONCLICK=\"javascript:if(confirm('Действительно хотите удалить?')) {return true;} else{return false;}\">Удалить файл</A>";
		}

		echo "</td></tr>
		<tr><td bgcolor=silver align=center><b>Поля с данными</b></td><td>
			<table border=1 cellspacing=0 cellpadding=3 width=100%>
			<tr bgcolor=silver align=center>
			<td><b>#</b></td>
			<td><b>Название</b></td>
			<td><b>Адрес ячейки</b></td>
			<td><b>Данные из заказа</b></td>
			</tr>\n";
			if (substr_count($DocDat["DataFieldsArr"], '%') > 0) {
				$Savd = explode("@", $DocDat["DataFieldsArr"]);
				$l = 1;
				foreach ($Savd as $SvDt) {
					list($Nazv, $Addr, $Data) = explode("%", $SvDt);
					echo "<tr align=center>
					<td>".$l."</td>
					<td><input type=text name=\"dtnazv".$l."\" size=40 value=\"".$Nazv."\"></td>
					<td><input type=text name=\"dtaddr".$l."\" size=10 value=\"".$Addr."\"></td>
					<td><input type=text name=\"dtdata".$l."\" size=40 value=\"".$Data."\"></td>
					</tr>\n";
					$l += 1;
				}
			}
			echo "<tr bgcolor=yellow align=center>
			<td>N</td>
			<td><input type=text name=\"dtnazv".$l."\" size=40></td>
			<td><input type=text name=\"dtaddr".$l."\" size=10></td>
			<td><input type=text name=\"dtdata".$l."\" size=40></td>
			</tr>\n";
		echo "</table>
		<input type=hidden name=\"dtklv\" value=\"".$l."\"
		</td></tr>
		<tr><td bgcolor=silver align=center><b>Строка с товаром:<br>перед какой строкой вставлять</b></td><td><input type=text name=\"lineins\" size=20 value=\"".$DocDat["DataLineInsBefore"]."\"></td></tr>

		<tr><td bgcolor=silver align=center><b>Строка с товаром: объединения ячеек</b></td><td>
			<table border=1 cellspacing=0 cellpadding=3 width=100%>
			<tr bgcolor=silver align=center>
			<td><b>#</b></td>
			<td><b>С ячейки</b></td>
			<td><b>По ячейку</b></td>
			</tr>\n";
			if (substr_count($DocDat["DataLineMerge"], '%') > 0) {
				$Savd = explode("@", $DocDat["DataLineMerge"]);
				$l = 1;
				foreach ($Savd as $SvDt) {
					list($From, $To) = explode("%", $SvDt);
					echo "<tr align=center>
					<td>".$l."</td>
					<td><input type=text name=\"mrgfrom".$l."\" size=10 value=\"".$From."\"></td>
					<td><input type=text name=\"mrgto".$l."\" size=10 value=\"".$To."\"></td>
					</tr>\n";
					$l += 1;
				}
			}

			echo "<tr bgcolor=yellow align=center>
			<td>N</td>
			<td><input type=text name=\"mrgfrom".$l."\" size=10></td>
			<td><input type=text name=\"mrgto".$l."\" size=10></td>
			</tr>
			<input type=hidden name=\"mergklv\" value=\"".$l."\">
		</table></td></tr>
		<tr><td bgcolor=silver align=center><b>Строка с товаром: данные</b></td><td>
			<table border=1 cellspacing=0 cellpadding=3 width=100%>
			<tr bgcolor=silver align=center>
			<td><b>#</b></td>
			<td><b>Название</b></td>
			<td><b>Адрес ячейки</b></td>
			<td><b>Данные по товару</b></td>
			<td><b>Выравнивание</b></td>
			<td><b>Формат</b></td>
			</tr>\n";
			if (substr_count($DocDat["DataLineValues"], '%') > 0) {
				$Savd = explode("@", $DocDat["DataLineValues"]);
				$l = 1;
				foreach ($Savd as $SvDt) {
					list($Nazv, $Addr, $Data, $Align, $Format) = explode("%", $SvDt);
					echo "<tr align=center>
					<td>".$l."</td>
					<td><input type=text name=\"zklinenazv".$l."\" size=40 value=\"".$Nazv."\"></td>
					<td><input type=text name=\"zklineaddr".$l."\" size=5 value=\"".$Addr."\"></td>
					<td><input type=text name=\"zklinedata".$l."\" size=20 value=\"".$Data."\"></td>
					<td><select name=\"zkalign".$l."\">";
					foreach($DocAlign as $id => $Params) {
						echo "<option value=\"".$id."\"";
						if ($id == $Align) {echo " selected";}
						echo ">".$Params[0]."</option>";
					}
					echo "</select></td>
					<td><input type=text name=\"zklineformat".$l."\" size=10 value=\"".$Format."\"></td>
					</tr>\n";
					$l += 1;
				}
			}

			echo "<tr bgcolor=yellow align=center>
			<td>N</td>
			<td><input type=text name=\"zklinenazv".$l."\" size=40></td>
			<td><input type=text name=\"zklineaddr".$l."\" size=5></td>
			<td><input type=text name=\"zklinedata".$l."\" size=20></td>
			<td><select name=\"zkalign".$l."\">";
			foreach($DocAlign as $id => $Params) {
				echo "<option value=\"".$id."\">".$Params[0]."</option>";
			}
			echo "</select></td>
			<td><input type=text name=\"zklineformat".$l."\" size=10></td>
			</tr></table>
			<input type=hidden name=\"linedatklv\" value=\"".$l."\">
		</td></tr>
		<tr><td colspan=2 align=center><input type=submit value=\"Обновить\"></td></tr>
		</table>
		</form>";
	break;

	case "savechngdoc":
		if (!isset($_GET["docid"]) || !is_numeric($_GET["docid"])) {die("<SCRIPT>history.back();</SCRIPT>");}
		$DocID = $_GET["docid"];

		$FName = "";
		if (isset($_FILES['strctimp']['tmp_name']) && $_FILES['strctimp']['tmp_name'] != "") {
			$FName = strtolower($instances["textfunct"]->translite($_FILES['strctimp']['name']));
			move_uploaded_file($_FILES['strctimp']['tmp_name'], $SPUrl."docs/".$FName);
			$FName = ", DocFile='".$FName."'";
		}

		$DocNazv = str_replace(array("'", '"'), array('', '&quot;'),  $_POST["docnazv"]);
		$LineBeforIns = str_replace(array("'", '"'), array('', '&quot;'),  $_POST["lineins"]);


		$Fields = "";
		for($i=1; $i<=$_POST["dtklv"]; $i++) {
			if ($_POST["dtaddr".$i] != "" && $_POST["dtdata".$i] != "") {
				$tNazv = str_replace(array("'", '"'), array('', '&quot;'),  $_POST["dtnazv".$i]);
				$tAddr = str_replace(array("'", '"'), array('', '&quot;'),  $_POST["dtaddr".$i]);
				$tData = str_replace(array("'", '"'), array('', '&quot;'),  $_POST["dtdata".$i]);
				if ($Fields != "") {$Fields .= "@";}
				$Fields .= $tNazv.'%'.$tAddr.'%'.$tData;
			}
		}

		$ZKLNMerge = "";
		for($i=1; $i<=$_POST["mergklv"]; $i++) {
			if (isset($_POST["mrgfrom".$i]) && $_POST["mrgfrom".$i] != "" && $_POST["mrgto".$i] != "") {
				$tFrom = str_replace(array("'", '"'), array('', '&quot;'),  $_POST["mrgfrom".$i]);
				$tTo = str_replace(array("'", '"'), array('', '&quot;'),  $_POST["mrgto".$i]);
				if ($ZKLNMerge != "") {$ZKLNMerge .= "@";}
				$ZKLNMerge .= $tFrom.'%'.$tTo;
			}
		}

		$ZKLNData = "";
		for($i=1; $i<=$_POST["linedatklv"]; $i++) {
			if ($_POST["zklineaddr".$i] != "" && $_POST["zklinedata".$i] != "") {
				$tNazv = str_replace(array("'", '"'), array('', '&quot;'),  $_POST["zklinenazv".$i]);
				$tAddr = str_replace(array("'", '"'), array('', '&quot;'),  $_POST["zklineaddr".$i]);
				$tData = str_replace(array("'", '"'), array('', '&quot;'),  $_POST["zklinedata".$i]);
				$tAlign = str_replace(array("'", '"'), array('', '&quot;'),  $_POST["zkalign".$i]);
				$tFormat = str_replace(array("'", '"'), array('', '&quot;'),  $_POST["zklineformat".$i]);
				if ($ZKLNData != "") {$ZKLNData .= "@";}
				$ZKLNData .= $tNazv.'%'.$tAddr.'%'.$tData.'%'.$tAlign.'%'.$tFormat;
			}
		}

		$r=mysql_query("UPDATE ".SQLPRFX." SET
		DocNazv='".$DocNazv."'".$FName.",DataFieldsArr='".$Fields."',DataLineInsBefore='".$LineBeforIns."',
		DataLineMerge='".$ZKLNMerge."', DataLineValues='".$ZKLNData."'
		WHERE DocID='".$DocID."';", $hlnk) or die ("Update :(");
		$r=mysql_query("OPTIMIZE TABLE ".SQLPRFX.";", $hlnk) or die("OPT :(");
		echo "<H2>Обновлено!</H2><SCRIPT>\n\nvar i = setTimeout(\"window.location.href='".$ModURL."&modact=editdoc&docid=".$DocID."'\", 200);\n</SCRIPT>";
	break;

	case "deldoc":
		if (!isset($_GET["docid"]) || !is_numeric($_GET["docid"])) {die("<SCRIPT>history.back();</SCRIPT>");}
		$DocID = $_GET["docid"];

		$r = mysql_query("SELECT DocFile
		FROM ".SQLPRFX." WHERE DocID='".$DocID."';", $hlnk) or die ("GetDocl");
		$DocDat = mysql_fetch_array($r);
		unlink($SPUrl."docs/".$DocDat["DocFile"]);

		$r = mysql_query("UPDATE ".SQLPRFX." SET DocFile=''
		WHERE DocID='".$DocID."';", $hlnk) or die ("GetDocl");
		$r=mysql_query("OPTIMIZE TABLE ".SQLPRFX.";", $hlnk) or die("OPT :(");
		echo "<H2>Удалено!</H2><SCRIPT>\n\nvar i = setTimeout(\"window.location.href='".$ModURL."&modact=editdoc&docid=".$DocID."'\", 200);\n</SCRIPT>";
	break;

	case "delfulldoc":
		if (!isset($_GET["docid"]) || !is_numeric($_GET["docid"])) {die("<SCRIPT>history.back();</SCRIPT>");}
		$DocID = $_GET["docid"];

		$r = mysql_query("SELECT DocFile
		FROM ".SQLPRFX." WHERE DocID='".$DocID."';", $hlnk) or die ("GetDocl");
		$DocDat = mysql_fetch_array($r);
		unlink($SPUrl."docs/".$DocDat["DocFile"]);

		$r=mysql_query("DELETE FROM ".SQLPRFX." WHERE DocID='".$DocID."';", $hlnk) or die ("DEL");
		$r=mysql_query("OPTIMIZE TABLE ".SQLPRFX."spis;", $hlnk) or die ("Optim");
		echo "<H2>Удалено!</H2><SCRIPT>\n\nvar i = setTimeout(\"window.location.href='".$ModURL."'\", 1000);\n</SCRIPT>";
	break;
}
?>