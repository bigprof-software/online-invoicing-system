<?php
	$app_dir = dirname(__FILE__) . '/..';
	define('PREPEND_PATH', '../');
	include("$app_dir/defaultLang.php");
	include("$app_dir/language.php");
	include("$app_dir/lib.php");

	restrict_access();
	include_once("$app_dir/header.php");

	$res = sql("SELECT i.id, c.name, i.date_due, i.total FROM invoices AS i, clients AS c WHERE i.client = c.id AND status='Unpaid' AND MONTH(date_due) = MONTH(CURRENT_DATE) AND YEAR(date_due)=YEAR(CURRENT_DATE) order by date_due", $eo);
	$total_invoice_due = sqlValue("SELECT SUM(total) FROM invoices WHERE status='Unpaid' AND MONTH(date_due) = MONTH(CURRENT_DATE) AND YEAR(date_due)=YEAR(CURRENT_DATE)", $eo);
?>

<?php echo report_actions(); ?>

<h1> All Due Invoices For <?php echo date('F Y'); ?></h1>
<?php if(db_num_rows($res)){?>
	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr class="text-bold text-primary h4">
				<th class="text-center">Invoice Number</th>
				<th class="text-center">Customer  Name </th>
				<th class="text-center">Invoice Date </th>
				<th class="text-center">Amount Due (<?php echo CURRENCY_SYMBOL; ?>)</th>
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
			<tr class="text-bold text-primary h4">
				<th colspan="3" class="text-right"><?php echo db_num_rows($res); ?> Due Invoices. Total (<?php echo CURRENCY_SYMBOL; ?>) </th>
				<th class="text-right"><?php echo number_format($total_invoice_due, 2);?></th>
			</tr>
		</tfoot>
	</table>
<?php }else{
	echo '<div class="alert alert-danger">' . $Translation['No records found']. '</div>';
}?>
	
<?php include_once("$app_dir/footer.php"); ?>