<?php
	define('PREPEND_PATH', '');
	$app_dir = dirname(__FILE__);
	include("{$app_dir}/defaultLang.php");
	include("{$app_dir}/language.php");
	include("{$app_dir}/lib.php");

	/*
	 * calculated fields configuration array, $calc:
	 *         table => [calculated fields], ..
	 *         where calculated fields:
	 *             field => query, ...
	 */
	$calc = calculated_fields();
	cleanup_calc_fields($calc);

	list($table, $id) = get_params();
	if(!$table || !strlen($id))
		return_json(array(), 'Access denied or invalid parameters');
	if(!isset($calc[$table]))
		return_json(array('table' => $table), 'No fields to calculate in this table');

	/*
		update_calc_fields($table, $id, $calc[$table])

		then, for each parent of $table and its parent's $parent_id 
		stored in record $id of $table:
		update_calc_fields($parent_table, $parent_id, $calc[$parent_table])
	 */
	$caluclations_made = array();
	$caluclations_made[] = update_calc_fields($table, $id, $calc[$table]);

	// get parents of current table
	$parents = get_parent_tables($table);
	$pk = getPKFieldName($table);
	$safe_id = makeSafe($id);
	foreach($parents as $pt => $mlufs /* main lookup fields in child */) {
		if(!isset($calc[$pt])) continue; // parent table has no calc fields

		foreach($mlufs as $mluf) {
			// retrieve parent record ID as stored in lookup field of current table
			$pid = sqlValue("SELECT `{$mluf}` FROM `{$table}` WHERE `{$pk}`='{$safe_id}'");
			if(!strlen($pid)) continue;

			$caluclations_made[] = update_calc_fields($pt, $pid, $calc[$pt]);
		}
	}

	return_json($caluclations_made);

	#############################################################

	/* get and validate params */
	function get_params() {
		$ret_error = array(false, false);

		$table = $_REQUEST['table'];
		$id = $_REQUEST['id'];
		if(!get_sql_from($table)) return $ret_error;
		if(!check_record_permission($table, $id)) return $ret_error;

		return array($table, $id);
	}

	function return_json($data = array(), $error = '') {
		@header('Content-type: application/json');
		die(json_encode(array('data' => $data, 'error' => $error)));
	}

	function cleanup_calc_fields(&$calc) {
		foreach($calc as $tn => $conf) {
			if(!count($conf)) unset($calc[$tn]);
		}
	}
