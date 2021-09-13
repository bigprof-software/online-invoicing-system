<?php
	$currDir = dirname(__FILE__);
	define('HOMEPAGE', true);
	include_once("{$currDir}/lib.php");

	$x = new DataList;
	$x->TableTitle = $Translation['homepage'];

	// according to provided GET parameters, either log out, show login form (possibly with a failed login message), or show homepage
	if(Request::val('signOut')) {
		logOutUser();
		redirect("index.php?signIn=1");
	} elseif(Request::val('signIn') || Request::val('loginFailed')) {
		if(Request::val('loginFailed')) @header('HTTP/1.0 403 Forbidden');
		include("{$currDir}/login.php");
	} else {
		include("{$currDir}/home.php");
	}