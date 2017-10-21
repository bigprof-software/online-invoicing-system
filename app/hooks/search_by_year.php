<?php
	$currDir = dirname(__FILE__) . '/..';
	define('PREPEND_PATH', '../');
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");

	restrict_access();
	include_once("$currDir/header.php");

	// get requested year between 1990 and 2100, assume current year if not provided
	$search_year = intval($_REQUEST['search']);
	if(!$search_year) $search_year = date('Y');
	$search_year = max(1990, min(2100, $search_year));

	$paid_res = sql("SELECT SUM(total) AS total, MONTH(date_due) AS month FROM invoices WHERE status='Paid' AND YEAR(date_due)='{$search_year}'  GROUP BY month", $error);

	$unpaid_res = sql("SELECT SUM(total) AS total, MONTH(date_due) AS month FROM invoices WHERE status='Unpaid' AND YEAR(date_due)='{$search_year}'  GROUP BY month", $error);

	// var_dump($unpaid->num_rows, $paid->num_rows);

	// get paid row if exists
	if($paid_res->num_rows) $monthly_paid = fetch($paid_res);

	// get all months totals
	$monthly_paid = get_totals($monthly_paid);
	

	// get unpaid row if exists
	if($unpaid_res->num_rows) $monthly_unpaid = fetch($unpaid_res);

	// get all months totals
	$monthly_unpaid = get_totals($monthly_unpaid);

	function fetch($result){
		$array = [];
		while($row = db_fetch_assoc($result)){
			$array[$row['month']] = $row['total'];
		}
		return $array;
	}

	function get_totals($result){
		$array = [];
		for($i = 1; $i <= 12; $i++){
			$array[$i] = (isset($result[$i]))? $result[$i] : 0;
		}
		return $array;
	}

?>


	<?php echo report_actions(); ?>
	
	<div class="page-header"><h1>Year <?php echo $search_year;?></h1></div>

	<table class="table table-striped table-bordered">
	    <thead>
			<tr>
				<th class="text-center text-primary">Month </th>
				<th class="text-center text-primary">Paid (<?php echo CURRENCY_SYMBOL; ?>)</th>
				<th class="text-center text-primary">Not Paid (<?php echo CURRENCY_SYMBOL; ?>)</th>
				<th class="text-center text-primary">Total (<?php echo CURRENCY_SYMBOL; ?>)</th>
			</tr>
		</thead>
		<tbody>
			<?php for($i =1; $i<=12; $i++) { ?>
				<tr>
					<td><?php echo date('F', strtotime("2017-{$i}-12")); ?></td>
					<td class="text-right"><?php echo number_format($monthly_paid[$i], 2); ?></td>
					<td class="text-right"><?php echo number_format($monthly_unpaid[$i], 2);?></td>
					<td class="text-right"><?php echo number_format($monthly_paid[$i] + $monthly_unpaid[$i], 2);?></td>
				</tr>
			<?php } ?>
		</tbody>
		<tfoot>
			<tr class="text-primary">
				<th class="text-left"> Totals</th>
				<th class="text-right"><?php echo number_format(array_sum($monthly_paid), 2);?></th>
				<th class="text-right"><?php echo number_format(array_sum($monthly_unpaid), 2);?></th>
				<th class="text-right"><?php echo number_format(array_sum($monthly_paid) + array_sum($monthly_unpaid), 2);?></th>
			</tr>
		</tfoot>
	</table>

<?php include_once("$currDir/footer.php"); ?>
