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

	function update_calc_fields($table, $id, $formulas) {
		$mi = getMemberInfo();
		$pk = getPKFieldName($table);
		$safe_id = makeSafe($id);
		$eo = array('silentErrors' => true);
		$caluclations_made = array();
		$replace = array(
			'%ID%' => $safe_id,
			'%USERNAME%' => makeSafe($mi['username']),
			'%GROUPID%' => makeSafe($mi['groupID']),
			'%GROUP%' => makeSafe($mi['group'])
		);

		foreach($formulas as $field => $query) {
			$query = str_replace(array_keys($replace), array_values($replace), $query);
			$calc_value = sqlValue($query);
			if($calc_value  === false) continue;

			// update calculated field
			$safe_calc_value = makeSafe($calc_value);
			$update_query = "UPDATE `{$table}` SET `{$field}`='{$safe_calc_value}' " .
				"WHERE `{$pk}`='{$safe_id}'";
			$res = sql($update_query, $eo);
			if($res) $caluclations_made[] = array(
				'table' => $table,
				'id' => $id,
				'field' => $field,
				'value' => $calc_value
			);
		}

		return $caluclations_made;
	}

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
