<?
include("init.php");
?>
<br><br><a href="parser_setup.php?menu=category_setup">Настройка категорий</a> | 
<a href="parser_setup.php?menu=parser_division">Сортировка товаров</a> | 
<a href="parser_setup.php?menu=parser_division_exclusion">Сортировка товаров (Исключение! Вспомнить!)</a>  

<?php

	$menu = 'category_setup';
	if(isset($_GET['menu'])) $menu = $_GET['menu'];

	//Подгрузка настроки по категориям
	if($menu == 'category_setup'){
		
		include 'setup/category_setup.php';
		
	}
	//Чтобы указать ключи при котором товары из той категории будут записаны в другую нужную
	if($menu == 'parser_division'){
		
		include 'setup/parser_division.php';
		
	}
	//Вспомнить что за таблица
	if($menu == 'parser_division_exclusion'){
		
		include 'setup/parser_division_exclusion.php';
		
	}
	
	
?>