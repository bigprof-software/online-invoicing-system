<?php
	$currDir = dirname(__FILE__).'/..';
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");

	restrict_access();
	
	$id = intval($_REQUEST['id']);
	if(!$id) exit;
    
        
        $total = sqlValue("select total from invoices where id='{$id}'");
	sql("update invoices set total='{$total}' where id='{$id}'",$eo);
        
	
	echo number_format($total, 2);
