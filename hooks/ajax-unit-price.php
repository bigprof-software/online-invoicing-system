<?php
	$currDir = dirname(__FILE__).'/..';
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	
	/* grant access to all users who have acess to the invoice_items table */
	$od_from = get_sql_from('invoice_items');
	if(!$od_from){
		header("HTTP/1.0 401 Unauthorized");
		exit;
	}
	
	$id = intval($_REQUEST['id']);
	
	$unit_price = sqlValue("select unit_price from items where id={$id}");
	
	echo $unit_price;
	
?>
