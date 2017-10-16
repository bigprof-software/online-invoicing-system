<?php
	$currDir = dirname(__FILE__).'/..';
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	
	/* grant access to all users who have acess to the invoices table */
	$od_from = get_sql_from('invoices');
	if(!$od_from){
		header("HTTP/1.0 401 Unauthorized");
		exit;
	}
	
	$id = intval($_REQUEST['id']);
	if(!$id) exit;
	
	$subtotal = sqlValue("select sum(price) from invoice_items where invoice='{$id}'");
	$tax = sqlValue("select tax from invoices where id='{$id}'");
	$discount = sqlValue("select discount from invoices where id='{$id}'");
	$total = $subtotal * (1 - $discount / 100) * (1 + $tax / 100);
	
	sql("update invoices set subtotal='{$subtotal}', total='{$total}' where id='{$id}'",$eo);
	echo number_format($subtotal, 2);