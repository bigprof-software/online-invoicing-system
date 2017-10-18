<?php
	define('PREPEND_PATH', '../');
	$app_dir = dirname(__FILE__) . '/..';
	include("$app_dir/defaultLang.php");
	include("$app_dir/language.php");
	include("$app_dir/lib.php");

	restrict_access();
	include_once("$app_dir/header.php");

	$res = sql("SELECT i.id, c.name, i.date_due, i.total FROM invoices AS i, clients AS c WHERE i.client = c.id AND status='Unpaid' AND MONTH(date_due) = MONTH(CURRENT_DATE + INTERVAL 1 MONTH) AND YEAR(date_due) = YEAR(CURRENT_DATE + INTERVAL 1 MONTH)", $eo);

	$total_invoice_upcoming = sqlValue("SELECT SUM(total) FROM invoices WHERE status='Unpaid' AND MONTH(date_due) = MONTH(CURRENT_DATE + INTERVAL 1 MONTH) AND YEAR(date_due) = YEAR(CURRENT_DATE + INTERVAL 1 MONTH)", $eo);
?>

	<?php echo report_actions(); ?>

	<div >
		<!-- company info -->
		<h1> All  Upcoming Invoices For <?php echo date('F Y', mktime(5, 1, 1, date('n') + 1, 1, date('Y'))); ?></h1>
	</div>

	<?php if(db_num_rows($res)){?>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th class="text-center" style="color:#0066ff ; font-size: 15px"> Invoice Number</th>
					<th class="text-center" style="color:#0066ff ; font-size: 15px">Customer  Name </th>
					<th class="text-center" style="color:#0066ff ; font-size: 15px">Invoice Date </th>
					<th class="text-center" style="color:#0066ff ; font-size: 15px">Total (<?php echo CURRENCY_SYMBOL; ?>)</th>
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
						<td class="text-center"><?php echo number_format($order['total'], 2); ?></td>
					</tr>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr style="color: red; font-size: 16px;">
					<th colspan="3" class="text-right">Total Upcoming Invoices</th>
					<th class="text-center"><?php echo number_format($total_invoice_upcoming, 2); ?></th>
				</tr>
			</tfoot>
		</table>
	<?php }else{ ?>
		<div class="alert alert-danger"><?php echo $Translation['No records found']; ?></div>
	<?php } ?>

<?php include_once("$app_dir/footer.php"); ?>

