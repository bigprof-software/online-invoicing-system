<?php
	$currDir = dirname(__FILE__) . '/..';
	define('PREPEND_PATH', '../');
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	include_once("$currDir/header.php");


	$search_year = intval(makeSafe($_REQUEST['search']));
	// echo $search_year;

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


<div class="row">
	<div class="input-group">
		<span class="input-group-btn">
			<a href="reports.php" class="btn btn-info hidden-print btn btn-secondary" role="button">Back to Reports</a>
		</span>
		<button class="btn btn-primary  hidden-print" type="button" id="sendToPrinter" onclick="window.print();"><i class="glyphicon glyphicon-print"></i> Print</button>
	</div>


	<h1> Year <?php echo $search_year;?> </h1>

	<table class="table table-striped table-bordered">
	    <thead>


	    <th class="text-center text-primary">Month </th>

	    <th class="text-center text-primary">$Paid </th>

	    <th class="text-center text-primary">$Not Paid </th>
		<th class="text-center text-primary">$Total </th>



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
	    <tr style="color: red; font-size: 16px;">
	        <th class="text-left"> Totals</th>
	        <th class="text-right">$<?php echo number_format(array_sum($monthly_paid), 2);?></th>
					
		  	<th class="text-right">$<?php echo number_format(array_sum($monthly_unpaid), 2);?></th>
		  		  
	  	  	<th class="text-right">$<?php echo number_format(array_sum($monthly_paid) + array_sum($monthly_unpaid), 2);?></th>
			  
		</tr>


	</tfoot>

	</table>
	<?php
	include_once("$currDir/footer.php");
	?>
</div>