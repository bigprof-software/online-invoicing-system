<?php
	define('PREPEND_PATH', '');
	include_once(__DIR__ . '/lib.php');

	// accept a record as an assoc array, return transformed row ready to insert to table
	$transformFunctions = [
		'invoices' => function($data, $options = []) {
			if(isset($data['date_due'])) $data['date_due'] = guessMySQLDateTime($data['date_due']);
			if(isset($data['client'])) $data['client'] = pkGivenLookupText($data['client'], 'invoices', 'client');
			if(isset($data['client_comments'])) $data['client_comments'] = preg_replace('/[^\d\.]/', '', $data['client_comments']);
			if(isset($data['tax'])) $data['tax'] = preg_replace('/[^\d\.]/', '', $data['tax']);
			if(isset($data['client_contact'])) $data['client_contact'] = thisOr($data['client'], pkGivenLookupText($data['client_contact'], 'invoices', 'client_contact'));
			if(isset($data['client_address'])) $data['client_address'] = thisOr($data['client'], pkGivenLookupText($data['client_address'], 'invoices', 'client_address'));
			if(isset($data['client_phone'])) $data['client_phone'] = thisOr($data['client'], pkGivenLookupText($data['client_phone'], 'invoices', 'client_phone'));
			if(isset($data['client_email'])) $data['client_email'] = thisOr($data['client'], pkGivenLookupText($data['client_email'], 'invoices', 'client_email'));
			if(isset($data['client_website'])) $data['client_website'] = thisOr($data['client'], pkGivenLookupText($data['client_website'], 'invoices', 'client_website'));
			if(isset($data['client_comments'])) $data['client_comments'] = thisOr($data['client'], pkGivenLookupText($data['client_comments'], 'invoices', 'client_comments'));

			return $data;
		},
		'clients' => function($data, $options = []) {
			if(isset($data['phone'])) $data['phone'] = str_replace('-', '', $data['phone']);

			return $data;
		},
		'item_prices' => function($data, $options = []) {
			if(isset($data['item'])) $data['item'] = pkGivenLookupText($data['item'], 'item_prices', 'item');
			if(isset($data['date'])) $data['date'] = guessMySQLDateTime($data['date']);

			return $data;
		},
		'invoice_items' => function($data, $options = []) {
			if(isset($data['invoice'])) $data['invoice'] = pkGivenLookupText($data['invoice'], 'invoice_items', 'invoice');
			if(isset($data['item'])) $data['item'] = pkGivenLookupText($data['item'], 'invoice_items', 'item');
			if(isset($data['unit_price'])) $data['unit_price'] = preg_replace('/[^\d\.]/', '', $data['unit_price']);
			if(isset($data['qty'])) $data['qty'] = preg_replace('/[^\d\.]/', '', $data['qty']);
			if(isset($data['current_price'])) $data['current_price'] = thisOr($data['item'], pkGivenLookupText($data['current_price'], 'invoice_items', 'current_price'));

			return $data;
		},
		'items' => function($data, $options = []) {

			return $data;
		},
	];

	// accept a record as an assoc array, return a boolean indicating whether to import or skip record
	$filterFunctions = [
		'invoices' => function($data, $options = []) { return true; },
		'clients' => function($data, $options = []) { return true; },
		'item_prices' => function($data, $options = []) { return true; },
		'invoice_items' => function($data, $options = []) { return true; },
		'items' => function($data, $options = []) { return true; },
	];

	/*
	Hook file for overwriting/amending $transformFunctions and $filterFunctions:
	hooks/import-csv.php
	If found, it's included below

	The way this works is by either completely overwriting any of the above 2 arrays,
	or, more commonly, overwriting a single function, for example:
		$transformFunctions['tablename'] = function($data, $options = []) {
			// new definition here
			// then you must return transformed data
			return $data;
		};

	Another scenario is transforming a specific field and leaving other fields to the default
	transformation. One possible way of doing this is to store the original transformation function
	in GLOBALS array, calling it inside the custom transformation function, then modifying the
	specific field:
		$GLOBALS['originalTransformationFunction'] = $transformFunctions['tablename'];
		$transformFunctions['tablename'] = function($data, $options = []) {
			$data = call_user_func_array($GLOBALS['originalTransformationFunction'], [$data, $options]);
			$data['fieldname'] = 'transformed value';
			return $data;
		};
	*/

	@include(__DIR__ . '/hooks/import-csv.php');

	$ui = new CSVImportUI($transformFunctions, $filterFunctions);
