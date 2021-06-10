<?php
	/**
	 * @file
	 * This file contains hook functions that get called when a new member signs up, 
	 * when a member signs in successfully and when a member fails to sign in.
	*/

	define('CURRENCY_TITLE', "US Dollars");
	define('CURRENCY_SYMBOL', "USD");
	
	/**
	 * This hook function is called when a member successfully signs in. 
	 * It can be used for example to redirect members to specific pages rather than the home page, 
	 * or to save a log of members' activity, ... etc.
	 * 
	 * @param $memberInfo
	 * An array containing logged member's info
	 * @see https://bigprof.com/appgini/help/working-with-generated-web-database-application/hooks/memberInfo
	 * 
	 * @param $args
	 * An empty array that is passed by reference. It's currently not used but is reserved for future uses.
	 * 
	 * @return
	 * A string containing the URL to redirect the member to. It can be a relative or absolute URL. 
	 * If the return string is empty, the member is redirected to the homepage (index.php).
	*/

	function login_ok($memberInfo, &$args) {

		return '';
	}

	/**
	 * This hook function is called when a login attempt fails.
	 * It can be used for example to log login errors.
	 * 
	 * @param $attempt
	 * An associative array that contains the following members:
	 * $attempt['username']: the username used to log in
	 * $attempt['password']: the password used to log in
	 * $attempt['IP']: the IP from wihich the login attempt was made
	 * 
	 * @param $args
	 * An empty array that is passed by reference. It's currently not used but is reserved for future uses.
	 * 
	 * @return
	 * None.
	*/

	function login_failed($attempt, &$args) {

	}

	/**
	 * This hook function is called when a new member signs up.
	 * 
	 * @param $memberInfo
	 * An array containing logged member's info
	 * @see https://bigprof.com/appgini/help/working-with-generated-web-database-application/hooks/memberInfo
	 * 
	 * @param $activity
	 * A string that takes one of the following values:
	 * 'pending': 
	 *     Means the member signed up through the signup form and awaits admin approval.
	 * 'automatic':
	 *     Means the member signed up through the signup form and was approved automatically.
	 * 'profile':
	 *     Means the member made changes to his profile.
	 * 'password':
	 *     Means the member changed his password.
	 * 
	 * @param $args
	 * An empty array that is passed by reference. It's currently not used but is reserved for future uses.
	 * 
	 * @return
	 * None.
	*/

	function member_activity($memberInfo, $activity, &$args) {
		switch($activity) {
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

	/**
	 * This hook function is called when an email is being sent
	 * 
	 * @param $pm is the PHPMailer object, passed by reference in order to easily modify its properties.
	 *            Documentation and examples can be found at https://github.com/PHPMailer/PHPMailer
	 *  
	 * @return none
	 */
	function sendmail_handler(&$pm) {

	}

	function print_invoice_query($id){
		$eo = ['silentErrors' => true];
		$query = sql("
					SELECT
						C.`name`, 
						I.`date_due`, I.`code`, I.`subtotal`, I.`discount`, I.`tax`, I.`total`,
						T.`item_description`, 
						IT.`unit_price`, IT.`qty`, IT.`price` 
					FROM 
						`clients` AS C INNER JOIN 
						`invoices` AS I ON C.`id` = I.`client` INNER JOIN 
						`invoice_items` AS IT ON IT.`invoice` = I.`id` INNER JOIN 
						`items` AS T ON T.`id` = IT.`item` 
					WHERE I.`id` = '{$id}'", $eo
				);

		$results = $totals = [];

		while($row = db_fetch_assoc($query)) {
			if(!$totals) {
				$totals_keys = ['code', 'name', 'date_due', 'subtotal', 'discount', 'tax', 'total'];
				foreach($row as $key => $value)
					if(in_array($key, $totals_keys)) $totals[$key] = $value;
				$totals['discount_amount'] = round($totals['subtotal'] * $totals['discount'] / 100, 2);
				$totals['tax_amount'] = round(($totals['subtotal'] - $totals['discount_amount']) * $totals['tax'] / 100, 2);
			}

			$results[] = [
				'item_description' => $row['item_description'],
				'unit_price'  	   => $row['unit_price'],
				'qty' 		  	   => $row['qty'],
				'price'			   => $row['price']
			];
		}

		if(count($totals) > 0) $results['totals'] = $totals;

		return $results;
	}
	
	function convertNumberToWord($num = false) {
		$num = str_replace([',', ' '], '', trim($num));
		if(!$num) return false;

		$fractions = round($num - intval($num), 2);
		$num = (int) $num;
		$words = [];
		$list1 = [
			'', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Eleven',
			'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'
		];
		$list2 = ['', 'Ten', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety', 'Hundred'];
		$list3 = [
			'', 'Thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
			'Octillion', 'Nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
			'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
		];

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
		}

		$commas = count($words);
		if($commas > 1) $commas--;

		return implode(' ', $words) . ($fractions ? " and {$fractions}" : '');
	}

