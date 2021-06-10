<?php
	$app_dir = dirname(__FILE__) . '/../..';
	define('PREPEND_PATH', '../../');

	include("$app_dir/lib.php");
	include_once("$app_dir/header.php");

	$id = max(0, intval($_REQUEST['id']));
	if(!$id){
		header('Location: ' . PREPEND_PATH . 'invoices_view.php');
		exit;
	}

	$results = print_invoice_query($id);
?>

<!-- non-printable buttons for printing and closing invoice -->
	<div class="btn-group hidden-print pull-right">
		<button type="button" class="btn btn-default btn-lg" onclick="window.close();">
			<i class="glyphicon glyphicon-chevron-left"></i> <?php echo html_attr($Translation['Back']); ?>
		</button>
		<button type="button" class="btn btn-primary btn-lg" onclick="window.print();">
			<i class="glyphicon glyphicon-print"></i> <?php echo $Translation['Print']; ?>
		</button>
	</div>
	<div class="clearfix"></div>
<!-- end of buttons -->
	
	<div style="margin-bottom: 1cm;">
		<img src="corporate-invoice-logo.png">
	</div>


	<table class="invoice-header">
		<tr>
			<th>Invoice #</th>
			<td><?php echo $results['totals']['code']; ?></td>
		</tr>
		<tr>
			<th>Client:</th>
			<td><?php echo $results['totals']['name']; ?></td>
		</tr>
		<tr>
			<th>Due date:</th>
			<td><?php echo date(config("adminConfig")['PHPDateFormat'], strtotime($results['totals']['date_due'])); ?></td>
		</tr>
	</table>
	<style>
		.invoice-header th{
			padding: 0.1cm 0.3cm;
			text-align: right;
		}
	</style>


	<div class="vspacer-lg"></div>

	<table class="table table-hover table-bordered">
		<thead>
			<tr>
				<th class="text-left" style="width: 50%;">Description</th>
				<th class="text-right">Unit price (<?php echo CURRENCY_SYMBOL; ?>)</th>
				<th class="text-right">Quantity</th>
				<th class="text-right">Price (<?php echo CURRENCY_SYMBOL; ?>)<span class="invisible">)</span></th>
			</tr>
		</thead>
		
		<tbody>
			<?php for($i = 0; $i < (count($results) - 1); $i++) { ?>
				<tr>
					<td class="text-left"><?php echo $results[$i]['item_description']; ?></td>
					<td class="text-right"><?php echo number_format($results[$i]['unit_price'], 2); ?></td>
					<td class="text-right"><?php echo number_format($results[$i]['qty'], 2); ?></td>
					<td class="text-right"><?php echo number_format($results[$i]['price'], 2); ?><span class="invisible">)</span></td>
				</tr>
			<?php } ?>
			
			<!-- subtotal -->
			<?php if($results['totals']['discount'] != 0 || $results['totals']['tax'] != 0){ ?>
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
			<tr>
				<th colspan="3" class="text-right">Total</th>
				<th class="text-right active"><?php echo number_format($results['totals']['total'], 2); ?><span class="invisible">)</span></th>
			</tr>
			<tr class="active">
				<th colspan="4" class="text-right">Only <?php echo convertNumberToWord($results['totals']['total']) . ' ' . CURRENCY_TITLE; ?> Due.</th>
			</tr>       
		</tbody>
	</table>

	<h4 class="text-center"><i>Thank you for your business!</i></h4>
	
<?php include_once("$app_dir/footer.php"); ?>