<?php
	error_reporting(E_ERROR | E_WARNING | E_PARSE);

	// incCommon.php is included only in the admin area, so if this flag is defined, this indicates we're in admin area
	define('ADMIN_AREA', true);

	if(!defined('datalist_db_encoding')) define('datalist_db_encoding', 'UTF-8');
	if(function_exists('set_magic_quotes_runtime')) @set_magic_quotes_runtime(0);
	ob_start();
	$currDir = dirname(__FILE__);
	include("{$currDir}/../db.php");
	include("{$currDir}/../settings-manager.php");

	// check if initial setup was performed or not
	detect_config();
	migrate_config();

	$adminConfig = config('adminConfig');
	include("{$currDir}/incFunctions.php");
	@include_once("{$currDir}/../hooks/__global.php");
	include("{$currDir}/../language.php");
	include("{$currDir}/../defaultLang.php");
	include("{$currDir}/../language-admin.php");

	// detecting classes not included above
	@spl_autoload_register(function($class) {
		$admin_dir = dirname(__FILE__);
		@include("{$admin_dir}/../resources/lib/{$class}.php");
	});

	/* trim $_POST, $_GET, $_REQUEST */
	if(count($_POST)) $_POST = array_trim($_POST);
	if(count($_GET)) $_GET = array_trim($_GET);
	if(count($_REQUEST)) $_REQUEST = array_trim($_REQUEST);

	initSession();

	// check if membership system exists
	setupMembership();

	/* do we have a JWT auth header? */
	jwt_check_login();

	// renew remember-me token, if applicable
	if(!getLoggedAdmin()) $remember_check = RememberMe::check();

	// is there a logged admin user?
	if(!($uname = getLoggedAdmin())) {
		// if no remember-me cookie, redirect to login page
		if(!$remember_check) die('<META HTTP-EQUIV="Refresh" CONTENT="0;url=../index.php">');

		// get username from remeber-me cookie, set session and redirect to admin homepage
		$uname = makeSafe(strtolower(RememberMe::user()));
		$_SESSION['memberID'] = $uname;
		$_SESSION['memberGroupID'] = sqlValue("SELECT `groupID` FROM `membership_users` WHERE LCASE(`memberID`)='{$uname}'");
		redirect('admin/pageHome.php');
	}

?>