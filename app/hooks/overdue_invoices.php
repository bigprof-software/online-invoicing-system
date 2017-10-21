<?php
	$app_dir = dirname(__FILE__) . '/..';
	define('PREPEND_PATH', '../');
	include("$app_dir/defaultLang.php");
	include("$app_dir/language.php");
	include("$app_dir/lib.php");

	restrict_access();
	include_once("$app_dir/header.php");

	$res = sql("SELECT I.id, I.status, I.date_due, I.total, C.name FROM invoices I, clients C WHERE I.client = C.id AND I.status='Unpaid' AND I.date_due <= LAST_DAY(CURRENT_DATE - INTERVAL 1 MONTH)", $eo);
	$total_invoice_overdue = sqlValue("SELECT SUM(total) FROM invoices WHERE status='Unpaid' AND date_due <= LAST_DAY(CURRENT_DATE - INTERVAL 1 MONTH)", $error);
	
	$c = config("adminConfig");
	$PHPDateFormat = $c['PHPDateFormat'];
?>

	<?php echo report_actions(); ?>
	
	<div class="page-header"><h1>All Overdue Invoices</h1></div>

	<?php if(db_num_rows($res)){?>
		<table class="table table-striped table-bordered">
			<thead>
				<th class="text-center" style="color:#0066ff ; font-size: 15px">Invoice Number</th>
				<th class="text-center" style="color:#0066ff ; font-size: 15px">Customer Name </th>
				<th class="text-center" style="color:#0066ff ; font-size: 15px">Invoice Date </th>
				<th class="text-center" style="color:#0066ff ; font-size: 15px">Invoice Total (<?php echo CURRENCY_SYMBOL; ?>)</th>
			</thead>
			<tbody>
				<?php while ($order = db_fetch_assoc($res)) { ?>
					<tr>
						<td class="text-center"><?php echo $order['id']; ?></td>
						<td class="text-left"><?php echo $order['name']; ?></td>
						<td class="text-center">
							<?php echo date($PHPDateFormat, strtotime($order['date_due'])); ?>
						</td>
						<td class="text-right"><?php echo number_format($order['total'], 2); ?></td>
					</tr>
				<?php } ?>

			</tbody>
			<tfoot>
				<tr style="color: red; font-size: 16px;">
					<th colspan="3" class="text-right">Total Overdue Invoices </th>
					<th class="text-right"><?php echo number_format($total_invoice_overdue, 2);?></th>
				</tr>
			</tfoot>
		</table>
	<?php }else{ ?>
		<div class="alert alert-danger"><?php echo $Translation['No records found']; ?></div>
	<?php } ?>

<?php include_once("$app_dir/footer.php"); ?>
