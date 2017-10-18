<?php
	$app_dir = dirname(__FILE__) .'/..';
	define('PREPEND_PATH', '../');
	include("$app_dir/defaultLang.php");
	include("$app_dir/language.php");
	include("$app_dir/lib.php");

	restrict_access();
	include_once("$app_dir/header.php");


	$custmer_id = makeSafe(intval($_REQUEST['search']));
	$invoices_fields = get_sql_fields('invoices');

	$res = sql("SELECT id, code, status, date_due, total FROM invoices WHERE client={$custmer_id} order by date_due", $eo);

	$name = sqlValue("SELECT name FROM clients WHERE id={$custmer_id} LIMIT 1", $eo);


	$year = date("Y");
	$month = date("m");

	$sql_total = "SELECT SUM(total) FROM invoices WHERE client='%d' AND status='%s' AND MONTH(date_due)='%s' AND YEAR(date_due)='%s'";

	$total_invoice_due = sqlValue(sprintf($sql_total, $custmer_id, 'Unpaid', $month, $year), $eo);


	$total_invoice_upcoming = sqlValue(sprintf($sql_total, $custmer_id, 'Unpaid', ++$month, $year), $eo);


	$total_invoice_over_due = sqlValue("SELECT SUM(total) FROM invoices WHERE client='{$custmer_id}' AND status='Unpaid' AND date_due <= LAST_DAY(CURRENT_DATE - INTERVAL 1 MONTH)", $eo);



	$total_invoice_cancelled = sqlValue("SELECT SUM(total) FROM invoices WHERE client='{$custmer_id}' AND status='Cancelled'", $eo);

	$total_invoice_paid = sqlValue("SELECT SUM(total) FROM invoices WHERE client='{$custmer_id}' AND status='Paid'", $eo);
	 
	$total = $total_invoice_due + $total_invoice_upcoming + $total_invoice_over_due + $total_invoice_paid + $total_invoice_cancelled;


?>

<?php echo report_actions(); ?>

<div class="row">
    <div class="col-xs-8 ">
        <h1>Invoices Of <?php echo $name; ?></h1>
    </div>
    <div class="col-xs-4 text-right " style="margin-top: 20px; color:red;" >
        <h4>Total invoices: <?php echo CURRENCY_SYMBOL; ?> <?php echo $total; ?> </h4>
    </div>             
</div>
<?php if(db_num_rows($res)){?>

	<table class="table table-striped table-bordered">
		<thead>

		<th class="text-center" style="color:#0066ff ; font-size: 15px">Invoice Code</th>
		<th class="text-center" style="color:#0066ff ; font-size: 15px">Status </th>
		<th class="text-center" style="color:#0066ff ; font-size: 15px">Due Date </th>
		<th class="text-center" style="color:#0066ff ; font-size: 15px">Total (<?php echo CURRENCY_SYMBOL; ?>)</th>


	</thead>

	<tbody>
		<?php while ($order = db_fetch_assoc($res)) { ?>
			<tr>
				<td class="text-center"><?php echo $order['code']; ?> </td>
				<td class="text-center"><?php echo $order['status']; ?></td>
				<td class="text-center"><?php
					$s = config("adminConfig");
					echo date($s['PHPDateFormat'], strtotime($order['date_due']));
				?></td>
				<td class="text-right"><?php echo number_format($order['total'], 2); ?></td>
			</tr>
			
	  <?php } ?>

	</tbody>
	<tfoot>

		<tr>
			<th colspan="3" class="text-right">Total cancelled invoices </th>
			<th class="text-right"><?php echo number_format($total_invoice_cancelled, 2); ?></th>
		</tr>
		<tr>
			<th colspan="3" class="text-right">Total paid invoices </th>
			<th class="text-right"><?php echo number_format($total_invoice_paid, 2); ?></th>
		</tr>

		<tr>
			<th colspan="3" class="text-right">Total upcoming invoices </th>
			<th class="text-right"><?php echo number_format($total_invoice_upcoming, 2); ?></th>
		</tr>
		
		<tr>
			<th colspan="3" class="text-right">Total due invoices </th>
			<th class="text-right"><?php echo number_format($total_invoice_due, 2); ?></th>
		</tr>

		<tr>
			<th colspan="3" class="text-right">Total  over-due invoices </th>
			<th class="text-right"><?php echo number_format($total_invoice_over_due, 2); ?></th>
		</tr>

		<tr style="color: red; font-size: 15px;">
			<th colspan="3" class="text-right">Total invoices</th>
			<th class="text-right"><?php echo number_format($total, 2); ?></th>
		</tr>
	</tfoot>

	</table>
<?php }else{ ?>
	<div class="alert alert-danger"><?php echo $Translation['No records found']; ?></div>
<?php } ?>

<?php include_once("$app_dir/footer.php"); ?>