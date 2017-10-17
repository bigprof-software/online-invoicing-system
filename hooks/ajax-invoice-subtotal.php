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
	if(!$subtotal) $subtotal = 0.0;
	
	$tax = sqlValue("select tax from invoices where id='{$id}'");
	if(!$tax) $tax = 0.0;
	
	$discount = sqlValue("select discount from invoices where id='{$id}'");
	if(!$discount) $discount = 0.0;
	
	$total = $subtotal * (1 - $discount / 100) * (1 + $tax / 100);
	
	sql("update invoices set subtotal='{$subtotal}', total='{$total}' where id='{$id}'",$eo);
	echo $subtotal;