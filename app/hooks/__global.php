<?php
	// For help on using hooks, please refer to http://bigprof.com/appgini/help/working-with-generated-web-database-application/hooks

	define('CURRENCY_TITLE', "US Dollars");
	define('CURRENCY_SYMBOL', "USD");
	
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
			if( !$totals ){
				$totals_keys = array('code', 'name', 'date_due', 'subtotal', 'discount', 'tax', 'total');
				foreach ($row as $key => $value) {
					if(in_array($key, $totals_keys)) $totals[$key] = $value;
				}
				$totals['discount_amount'] = round($totals['subtotal'] * $totals['discount'] / 100, 2);
				$totals['tax_amount'] = round(($totals['subtotal'] - $totals['discount_amount']) * $totals['tax'] / 100, 2);
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

	function convertNumberToWord($num = false) {
		$num = str_replace(array(',', ' '), '', trim($num));
		if (!$num) {
			return false;
		}
		$fractions = round($num - intval($num), 2);
		$num = (int) $num;
		$words = array();
		$list1 = array('', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Eleven',
			'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'
		);
		$list2 = array('', 'Ten', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety', 'Hundred');
		$list3 = array('', 'Thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
			'Octillion', 'Nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
			'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
		);
		$num_length = strlen($num);
		$levels = (int) (($num_length + 2) / 3);
		$max_length = $levels * 3;
		$num = substr('00' . $num, -$max_length);
		$num_levels = str_split($num, 3);
		for ($i = 0; $i < count($num_levels); $i++) {
			$levels--;
			$hundreds = (int) ($num_levels[$i] / 100);
			$hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' Hundred' . ( $hundreds == 1 ? '' : '' ) . ' ' : '');
			$tens = (int) ($num_levels[$i] % 100);
			$singles = '';
			if ($tens < 20) {
				$tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
			} else {
				$tens = (int) ($tens / 10);
				$tens = ' ' . $list2[$tens] . ' ';
				$singles = (int) ($num_levels[$i] % 10);
				$singles = ' ' . $list1[$singles] . ' ';
			}
			$words[] = $hundreds . $tens . $singles . ( ( $levels && (int) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
		} //end for loop
		$commas = count($words);
		if ($commas > 1) {
			$commas = $commas - 1;
		}
		return implode(' ', $words) . ($fractions ? " and {$fractions}" : '');
	}

	/**
	 *  @return HTML code for report action buttons (back, print, .. etc)
	 */
	function report_actions(){
		global $Translation;
		
		ob_start();
		?>
		<a href="reports.php" class="btn btn-info hidden-print btn-lg" role="button"><i class="glyphicon glyphicon-chevron-left"></i> <?php echo $Translation['Back']; ?></a>
		<button class="btn btn-primary hidden-print btn-lg hspacer-lg" type="button" id="sendToPrinter" onclick="window.print();"><i class="glyphicon glyphicon-print"></i> <?php echo $Translation['Print']; ?></button>
		<?php
		$out = ob_get_contents();
		ob_end_clean();
		
		return $out;
	}
	
	function restrict_access($table = 'invoices'){
		$from_chk = get_sql_from($table);
		if(!$from_chk){
			header("HTTP/1.0 401 Unauthorized");
			exit;
		}
	}