<?php
	$currDir = dirname(__FILE__).'/..';
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	
	restrict_access();
	
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