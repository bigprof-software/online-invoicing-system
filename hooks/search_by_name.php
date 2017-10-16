<?php
$currDir = dirname(__FILE__) .'/..';
define('PREPEND_PATH', '../');
include("$currDir/defaultLang.php");
include("$currDir/language.php");
include("$currDir/lib.php");
include_once("$currDir/header.php");


$custmer_id = makeSafe(intval($_REQUEST['search']));
$invoices_fields = get_sql_fields('invoices');

$res = sql("SELECT id, status, date_due, total FROM invoices WHERE client={$custmer_id}", $eo);

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



<div class="input-group">
	<span class="input-group-btn">
		<a href="invoice_button.php?search_by_customer=1" class="btn btn-info hidden-print btn btn-secondary" role="button">Back to Reports</a>
	</span>
	<button class="btn btn-primary  hidden-print" type="button" id="sendToPrinter" onclick="window.print();"><i class="glyphicon glyphicon-print"></i> Print</button>
</div>

<div class="row">
    <div class="col-xs-8 ">
        <h1>   <?php echo $name; ?></h1>
    </div>
    <div class="col-xs-4 text-right " style="margin-top: 20px; color:red;" >
        <h4> Total invoices: $<?php echo $total; ?> </h4>
    </div>             
</div>
<?php if(db_num_rows($res)){?>

<table class="table table-striped table-bordered">
    <thead>

    <th class="text-center" style="color:#0066ff ; font-size: 15px">Invoice id</th>
    <th class="text-center" style="color:#0066ff ; font-size: 15px">Status </th>
    <th class="text-center" style="color:#0066ff ; font-size: 15px">Due Date </th>
    <th class="text-center" style="color:#0066ff ; font-size: 15px">$Total </th>


</thead>

<tbody>
	<?php while ($order = db_fetch_assoc($res)) { ?>
		<tr>
			<td class="text-center"><?php echo $order['id']; ?> </td>
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
        <th class="text-right">$<?php echo number_format($total_invoice_cancelled, 2); ?></th>
    </tr>
    <tr>
        <th colspan="3" class="text-right">Total paid invoices </th>
        <th class="text-right">$<?php echo number_format($total_invoice_paid, 2); ?></th>
    </tr>

    <tr>
        <th colspan="3" class="text-right">Total upcoming invoices </th>
        <th class="text-right">$<?php echo number_format($total_invoice_upcoming, 2); ?></th>
    </tr>
    
    <tr>
        <th colspan="3" class="text-right">Total due invoices </th>
        <th class="text-right">$<?php echo number_format($total_invoice_due, 2); ?></th>
    </tr>

    <tr>
        <th colspan="3" class="text-right">Total  over-due invoices </th>
        <th class="text-right">$<?php echo number_format($total_invoice_over_due, 2); ?></th>
    </tr>

    <tr style="color: red; font-size: 15px;">
        <th colspan="3" class="text-right">Total invoices</th>
        <th class="text-right">$<?php echo number_format($total, 2); ?></th>
    </tr>
</tfoot>

</table>
<?php 
}else{
	echo '<div class="alert alert-danger">' . $Translation['No records found']. '</div>';
}?>
<?php
include_once("$currDir/footer.php");
?>