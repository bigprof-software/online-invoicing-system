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
		$query = sql("SELECT C.name, I.date_due, I.code, I.subtotal, I.discount, I.tax, I.total,
				 T.item_description, IT.unit_price, IT.qty, IT.price FROM clients AS C 
				 INNER JOIN invoices AS I ON C.id = I.client 
				 INNER JOIN invoice_items AS IT ON IT.invoice = I.id 
				 INNER JOIN items AS T ON T.id = IT.item 
				 WHERE I.id = '{$id}'
				 GROUP BY T.id", $error);

		$results = [];
		$totals = [];

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
			$results[] 			= [
				'item_description' => $row['item_description'],
				'unit_price'  	   => $row['unit_price'],
				'qty' 		  	   => $row['qty'],
				'price'			   => $row['price']
			];
		}

		if(count($totals) > 0){
			$results['totals'] = $totals;
		}

		return $results;
	}