<?php
/* mass_update: Applying command: Mark as cancelled */
$allowed_groups = '*';

$hooks_dir = dirname(__FILE__);
include("{$hooks_dir}/../defaultLang.php");
include("{$hooks_dir}/../language.php");
include("{$hooks_dir}/../lib.php");

// check permissions
$user = getMemberInfo();
if($allowed_groups == '*') {
	// allow any signed user
	if(!$user['username'] || $user['username'] == 'guest') {
		@header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
		exit;
	}
} elseif(!in_array($user['group'], $allowed_groups)) {
	@header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
	exit;
}

/* receive and validate calling parameters */
$ids = $_REQUEST['ids'];
if(empty($ids) || !is_array($ids)) {
	@header($_SERVER['SERVER_PROTOCOL'] . ' 501 Not Implemented');
	exit;
}


$new_value = makeSafe('Cancelled');

/* prepare a safe comma-separated list of IDs to use in the query */
$cs_ids = array();
foreach($ids as $id) $cs_ids[] = "'" . makeSafe($id) . "'";
$cs_ids = implode(', ', $cs_ids);

$tn = 'invoices';
$field = 'status';
$pk = getPKFieldName($tn);

$query = "UPDATE `{$tn}` SET `{$field}`='{$new_value}' WHERE `{$pk}` IN ({$cs_ids})";


$e = array('silentErrors' => true);
sql($query, $e);

if($e['error']) {
	@header($_SERVER['SERVER_PROTOCOL'] . ' 501 Not Implemented');
}

