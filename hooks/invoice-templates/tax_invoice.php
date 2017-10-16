<?php
$currDir = dirname(__FILE__) . '/../..';
define('PREPEND_PATH', '../../');
include("$currDir/defaultLang.php");
include("$currDir/language.php");
include("$currDir/lib.php");
include_once("$currDir/header.php");

$search_to = makeSafe($_REQUEST['id']);

$results = print_invoice_query($search_to);

if( count($results) > 0 ){


function convertNumberToWord($num = false) {
	$num = str_replace(array(',', ' '), '', trim($num));
	if (!$num) {
		return false;
	}
	$fractions = round($num - intval($num), 2);
	$num = (int) $num;
	$words = array();
	$list1 = array('', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Eleven',
		'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'
	);
	$list2 = array('', 'Ten', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety', 'Hundred');
	$list3 = array('', 'Thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
		'Octillion', 'Nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
		'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
	);
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
	} //end for loop
	$commas = count($words);
	if ($commas > 1) {
		$commas = $commas - 1;
	}
	return implode(' ', $words) . ($fractions ? " and {$fractions}" : '');
}


?>

<div class="input-group">
	<span class="input-group-btn">
		<a href="../../invoices_view.php?SelectedID=<?php echo urlencode($_REQUEST['id']) ?>" class="btn btn-info hidden-print btn btn-secondary" role="button">Cancel printing</a>
	</span>
	<button class="btn btn-primary  hidden-print" type="button" id="sendToPrinter" onclick="window.print();"><i class="glyphicon glyphicon-print"></i> Print</button>
</div>



		
<!-- Bootstarp image class needed here-->

<div>
	<img src="../../resources/images/nontax.png" style="width: 200px; margin-bottom: 50px;">
</div>

<div style="font-weight: bold; font-size: 16px;">
	<p>Invoice ref # <?php echo $results['totals']['code']; ?> </p>
	<p>Client: <?php echo $results['totals']['name']; ?></p>
	<?php $s = config("adminConfig"); ?>

	<p>Due date: <?php echo date($s['PHPDateFormat'], strtotime($results['totals']['date_due'])); ?> </p>
</div>

		
		<div class="vspacer-lg"></div>

		<table class="table table-striped table-bordered">
			<thead>

			<th class="text-center text-primary">Description</th>
			<th class="text-center text-primary">$Unit price </th>

			<th class="text-center text-primary">Quantity </th>

			<th class="text-center text-primary">$Price </th>




			</thead>
			
			<tbody>
				
				<?php for($i=0; $i< (count($results) - 1); $i++){?>
					<tr>

						<td class="text-left"><?php echo $results[$i]['item_description']; ?></td>
						<td class="text-right"><?php echo number_format($results[$i]['unit_price'], 2); ?></td>
						<td class="text-right"><?php echo number_format($results[$i]['qty'], 2); ?></td>
						<td class="text-right"><?php echo number_format($results[$i]['price'], 2); ?></td>

					</tr>
				<?php } ?>
			</tbody>
			<tfoot>
				
				
				
				<tr>
					<th colspan="3" class="text-right">SubTotal </th>
					<th class="text-right"><?php echo number_format($results['totals']['subtotal'], 2); ?></th>
				</tr>
								
				<tr>
					<th colspan="3" class="text-right">Discount </th>
					<th class="text-right"><?php echo number_format($results['totals']['discount'], 2); ?></th>
				</tr>
				
				<tr>
					<th colspan="3" class="text-right" style="color: red;">Total</th>
					<th class="text-right" style="color: red;">$<?php echo number_format($results['totals']['total'], 2); ?></th>
				</tr>
				
				<tr>
					<th colspan="4" class="text-right" style="color: red;"><?php echo "Only " . convertNumberToWord($results['totals']['total']) . " ".$currency_title."  due"; ?> </th>
				</tr>       




			</tfoot>



		</table>

		<h4 class="text-center"><i>Thank you for your business</i></h4>
<?php
}else{
	header('Location: ../../invoices_view.php');
}
include_once("$currDir/footer.php");
?>