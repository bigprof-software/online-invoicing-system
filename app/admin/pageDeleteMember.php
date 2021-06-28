<?php
	$currDir=dirname(__FILE__);
	require("$currDir/incCommon.php");

	// validate input
	$memberID=makeSafe(strtolower($_GET['memberID']));

	if(!csrf_token(true)) die($Translation['csrf token expired or invalid']);

	sql("delete from membership_users where lcase(memberID)='$memberID'", $eo);
	sql("update membership_userrecords set memberID='' where lcase(memberID)='$memberID'", $eo);

	if($_SERVER['HTTP_REFERER']) {
		redirect($_SERVER['HTTP_REFERER'], TRUE);
	} else {
		redirect("admin/pageViewMembers.php");
	}

?>