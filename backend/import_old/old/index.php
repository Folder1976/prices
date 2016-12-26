<?
include("init.php");
include("forms.php");


if($_POST['importtype']){
	include($_POST['importtype'].".php");
}
?>