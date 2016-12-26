<?php
	setcookie('hide_menu_help', true, time()+3600);
	echo 'hide';
	$_SESSION['hide_menu_help'] = true;
?>