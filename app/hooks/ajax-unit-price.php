<?php
	$currDir = dirname(__FILE__).'/..';
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	
	restrict_access('items');
	
	$id = intval($_REQUEST['id']);
	
	$unit_price = sqlValue("select unit_price from items where id={$id}");
	
	echo $unit_price;
	
?>
