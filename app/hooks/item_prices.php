<?php
	// For help on using hooks, please refer to https://bigprof.com/appgini/help/working-with-generated-web-database-application/hooks

	function item_prices_init(&$options, $memberInfo, &$args){

		return TRUE;
	}

	function item_prices_header($contentType, $memberInfo, &$args){
		$header='';

		switch($contentType){
			case 'tableview':
				$header='';
				break;

			case 'detailview':
				$header='';
				break;

			case 'tableview+detailview':
				$header='';
				break;

			case 'print-tableview':
				$header='';
				break;

			case 'print-detailview':
				$header='';
				break;

			case 'filters':
				$header='';
				break;
		}

		return $header;
	}

	function item_prices_footer($contentType, $memberInfo, &$args){
		$footer='';

		switch($contentType){
			case 'tableview':
				$footer='';
				break;

			case 'detailview':
				$footer='';
				break;

			case 'tableview+detailview':
				$footer='';
				break;

			case 'print-tableview':
				$footer='';
				break;

			case 'print-detailview':
				$footer='';
				break;

			case 'filters':
				$footer='';
				break;
		}

		return $footer;
	}

	function item_prices_before_insert(&$data, $memberInfo, &$args){

		return TRUE;
	}

	function item_prices_after_insert($data, $memberInfo, &$args){
		update_item_latest_price($data['item']);
		return TRUE;
	}

	function item_prices_before_update(&$data, $memberInfo, &$args){

		return TRUE;
	}

	function item_prices_after_update($data, $memberInfo, &$args){
		update_item_latest_price($data['item']);
		return TRUE;
	}

	function item_prices_before_delete($selectedID, &$skipChecks, $memberInfo, &$args){
		$GLOBALS['deleted_item_id'] = sqlValue("select item from item_prices where id='{$selectedID}'");
		return TRUE;
	}

	function item_prices_after_delete($selectedID, $memberInfo, &$args){
		update_item_latest_price($GLOBALS['deleted_item_id']);
	}

	function item_prices_dv($selectedID, $memberInfo, &$html, &$args){

	}

	function item_prices_csv($query, $memberInfo, &$args){

		return $query;
	}
	function item_prices_batch_actions(&$args){

		return array();
	}
