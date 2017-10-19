<?php
	$app_dir = dirname(__FILE__) . '/..';
	define('PREPEND_PATH', '../');
	include("$app_dir/defaultLang.php");
	include("$app_dir/language.php");
	include("$app_dir/lib.php");

	restrict_access();
	include_once("$app_dir/header.php");

	$res = sql("SELECT I.id, I.status, I.date_due, I.total, C.name FROM invoices I, clients C WHERE I.client = C.id AND status='Unpaid' AND (MONTH(date_due)= MONTH(CURRENT_DATE) OR MONTH(date_due)=MONTH(CURRENT_DATE+ INTERVAL 1 MONTH)) AND YEAR(date_due)=YEAR(CURRENT_DATE + INTERVAL 1 MONTH)", $eo);
	$total_invoice_due_and_upcoming = sqlValue("SELECT SUM(total) FROM invoices WHERE status='Unpaid' AND (MONTH(date_due)= MONTH(CURRENT_DATE) OR MONTH(date_due)=MONTH(CURRENT_DATE+ INTERVAL 1 MONTH)) AND YEAR(date_due)=YEAR(CURRENT_DATE + INTERVAL 1 MONTH)", $eo);
?>

<?php echo report_actions(); ?>

<div class="page-header"><h1>Upcoming and Due Invoices</h1></div>

<?php if(db_num_rows($res)){?>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th class="text-center" style="color:#0066ff ; font-size: 15px">Invoice Number</th>
				<th class="text-center" style="color:#0066ff ; font-size: 15px">Customer  Name </th>
				<th class="text-center" style="color:#0066ff ; font-size: 15px">Invoice Date </th>
				<th class="text-center" style="color:#0066ff ; font-size: 15px">Invoice Total (<?php echo CURRENCY_SYMBOL; ?>)</th>
			</tr>
		</thead>
		<tbody>
			<?php while ($order = db_fetch_assoc($res)) { ?>
				<tr>
					<td class="text-center"><?php echo $order['id']; ?></td>
					<td class="text-left"><?php echo $order['name']; ?></td>
					<td class="text-center">
						<?php
							$s = config("adminConfig");
							echo date($s['PHPDateFormat'], strtotime($order['date_due']));
						?>
					</td>
					<td class="text-right"><?php echo number_format($order['total'], 2); ?></td>
				</tr>
			<?php } ?>
		</tbody>
		<tfoot>
			<tr style="color: red; font-size: 16px;">
				<th colspan="3" class="text-right">Total Due and Upcoming Invoices</th>
				<th class="text-right"><?php echo number_format($total_invoice_due_and_upcoming, 2);?></th>
			</tr>
		</tfoot>
	</table>
<?php }else{ ?>
	<div class="alert alert-danger"><?php echo $Translation['No records found']; ?></div>
<?php } ?>

<?php include_once("$app_dir/footer.php"); ?>

