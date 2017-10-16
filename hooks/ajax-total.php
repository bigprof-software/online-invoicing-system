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
    
        
        $total = sqlValue("select total from invoices where id='{$id}'");
	sql("update invoices set total='{$total}' where id='{$id}'",$eo);
        
	
	echo number_format($total, 2);
