<?php
	$app_dir = dirname(__FILE__) . '/../..';
	define('PREPEND_PATH', '../../');

	include("$app_dir/defaultLang.php");
	include("$app_dir/language.php");
	include("$app_dir/lib.php");
	include_once("$app_dir/header.php");

	$id = max(0, intval($_REQUEST['id']));
	if(!$id){
		header('Location: ' . PREPEND_PATH . 'invoices_view.php');
		exit;
	}

	$results = print_invoice_query($id);

	?>
	
	<a href="<?php echo PREPEND_PATH; ?>invoices_view.php?SelectedID=<?php echo urlencode($id) ?>" class="btn btn-info hidden-print btn-lg"><i class="glyphicon glyphicon-chevron-left"></i> <?php echo html_attr($Translation['Back']); ?></a>
	<button class="btn btn-primary hidden-print btn-lg hspacer-lg" type="button" id="sendToPrinter" onclick="window.print();"><i class="glyphicon glyphicon-print"></i> Print</button>

	<!-- Bootstarp image class needed here-->

	<div>
		<img src="<?php echo PREPEND_PATH; ?>resources/images/nontax.png" style="width: 200px; margin-bottom: 50px;">
	</div>

	<div style="font-weight: bold; font-size: 16px;">
		<p>Invoice # <?php echo $results['totals']['code']; ?> </p>
		<p>Client: <?php echo $results['totals']['name']; ?></p>
		<?php $s = config("adminConfig"); ?>

		<p>Due date: <?php echo date($s['PHPDateFormat'], strtotime($results['totals']['date_due'])); ?> </p>
	</div>

			
	<div class="vspacer-lg"></div>

	<table class="table table-hover table-bordered">
		<thead>
			<tr class="active">
				<th class="text-center text-primary">Description</th>
				<th class="text-center text-primary">Unit price </th>
				<th class="text-center text-primary">Quantity </th>
				<th class="text-center text-primary">Price </th>
			</tr>
		</thead>
		
		<tbody>
			<?php for($i=0; $i< (count($results) - 1); $i++){?>
				<tr>
					<td class="text-left"><?php echo $results[$i]['item_description']; ?></td>
					<td class="text-right"><?php echo number_format($results[$i]['unit_price'], 2); ?></td>
					<td class="text-right"><?php echo number_format($results[$i]['qty'], 2); ?></td>
					<td class="text-right"><?php echo number_format($results[$i]['price'], 2); ?><span class="invisible">)</span></td>
				</tr>
			<?php } ?>
			
			<!-- subtotal -->
			<?php if($results['totals']['discount'] != 0 && $results['totals']['tax'] != 0){ ?>
				<tr class="active"><td colspan="4"></td></tr>
				<tr>
					<th colspan="3" class="text-right">Subtotal </th>
					<th class="text-right active"><?php echo number_format($results['totals']['subtotal'], 2); ?><span class="invisible">)</span></th>
				</tr>
			<?php } ?>

			<!-- discount -->
			<?php if($results['totals']['discount'] != 0){ ?>
				<tr>
					<th colspan="3" class="text-right">Discount (<?php echo number_format($results['totals']['discount'], 2); ?>%)</th>
					<th class="text-right active">
						<?php if($results['totals']['discount_amount'] > 0){ ?>
							(<?php echo number_format($results['totals']['discount_amount'], 2); ?>)
						<?php }else{ ?>
							<?php echo number_format($results['totals']['discount_amount'], 2); ?><span class="invisible">)</span>
						<?php } ?>
					</th>
				</tr>
			<?php } ?>

			<!-- tax -->
			<?php if($results['totals']['tax'] != 0){ ?>
				<tr>
					<th colspan="3" class="text-right">Tax (<?php echo number_format($results['totals']['tax'], 2); ?>%)</th>
					<th class="text-right active"><?php echo number_format($results['totals']['tax_amount'], 2); ?><span class="invisible">)</span></th>
				</tr>
			<?php } ?>

			<tr class="active"><td colspan="4"></td></tr>

			<!-- total -->
			<tr class="active">
				<th colspan="3" class="text-right">Total</th>
				<th class="text-right"><?php echo number_format($results['totals']['total'], 2); ?><span class="invisible">)</span></th>
			</tr>
			<tr class="active">
				<th colspan="4" class="text-right">Only <?php echo convertNumberToWord($results['totals']['total']) . ' ' . CURRENCY_TITLE; ?> Due.</th>
			</tr>       
		</tbody>
	</table>

	<h4 class="text-center"><i>Thank you for your business!</i></h4>
	
<?php include_once("$app_dir/footer.php"); ?>