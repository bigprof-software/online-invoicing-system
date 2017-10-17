<?php
	// For help on using hooks, please refer to http://bigprof.com/appgini/help/working-with-generated-web-database-application/hooks

	$currency_title="Egyptian Pounds";
	
	function login_ok($memberInfo, &$args){

		return '';
	}

	function login_failed($attempt, &$args){

	}

	function member_activity($memberInfo, $activity, &$args){
		switch($activity){
			case 'pending':
				break;

			case 'automatic':
				break;

			case 'profile':
				break;

			case 'password':
				break;

		}
	}


	function print_invoice_query($id){
		$query = sql("
					SELECT
						C.name, 
						I.date_due, I.code, I.subtotal, I.discount, I.tax, I.total,
						T.item_description, 
						IT.unit_price, IT.qty, IT.price 
					FROM 
						clients AS C INNER JOIN 
						invoices AS I ON C.id = I.client INNER JOIN 
						invoice_items AS IT ON IT.invoice = I.id INNER JOIN 
						items AS T ON T.id = IT.item 
					WHERE I.id = '{$id}'
					GROUP BY T.id", $error);

		$results = array();
		$totals = array();

		while ($row = db_fetch_assoc($query)) {
			foreach ($row as $key => $value) {
				if( !$totals ){
					$totals['code']     = $row['code'];
					$totals['name']     = $row['name'];
					$totals['date_due']     = $row['date_due'];
					$totals['subtotal'] = $row['subtotal'];
					$totals['discount'] = $row['discount'];
					$totals['total'] 	= $row['total'];
				}
			}
			$results[] = array(
				'item_description' => $row['item_description'],
				'unit_price'  	   => $row['unit_price'],
				'qty' 		  	   => $row['qty'],
				'price'			   => $row['price']
			);
		}

		if(count($totals) > 0){
			$results['totals'] = $totals;
		}

		return $results;
	}

	function update_item_latest_price($item_id){
		$item_id = max(0, intval($item_id));
		$last_price = get_item_price($item_id);
		
		sql("update items set unit_price='{$last_price}' where id='{$item_id}'", $eo);
		
		return $last_price;
	}
	
	function get_item_price($item_id, $date = false){
		if($date === false) $date = date('Y-m-d');
		$item_id = max(0, intval($item_id));

		$last_price = sqlValue("select price from item_prices where item='{$item_id}' and date<='{$date}' order by date desc, id desc limit 1", $eo);
		if(!$last_price){
			return sqlValue("select unit_price from items where id='{$item_id}'");
		}
		
		return $last_price;
	}

	/* retrieve all products as an array of assoc. arrays, cached */
	function get_products(){
		static $products = false;
		if($products !== false) return $products;
		
		$products = array();
		$res = sql("select * from products order by id", $eo);
		while($row = db_fetch_assoc($res)){
			$products[] = $row;
		}
		
		return $products;
	}
	
	/* 
		takes array like this:
		[
			['koko' => 123, 'lolo' => 'abc'],
			['koko' => 245, 'lolo' => 'xyz'],
			['koko' => 667, 'lolo' => 'wer']
		]
		and returns array like this (if @param key is 'koko'):
		[123, 245, 667]
	*/
	function array_flatten($arr, $key){
		if(!is_array($arr)) return array();
		
		$fa = array(); /* flat array to return */
		foreach($arr as $sa){
			if(!isset($sa[$key])) continue;
			$fa[] = $sa[$key];
		}
		
		return $fa;
	}
