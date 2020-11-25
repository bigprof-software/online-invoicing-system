/**
* function to redirect to the selected print invoice template
* @return void
*/
function printInvoice() {
	var invoiceId = $j('[name=SelectedID]').val();

	/**
	* @var template string the name of the template (changing the selected option to lower case then *replacing spaces with underscores)
	*/
	var template = $j("#invoice_template").val().trim();
	if(template == '') {
		alert('No invoice template specified. Please select a template first.');
		AppGini.scrollTo('invoice_template');
		$j('#s2id_invoice_template').select2('open');
		return false;
	}
	
	var templatePage = template.toLowerCase().replace(/\s/g, '_') + ".php";
	window.open("hooks/invoice-templates/" + templatePage + "?id=" + invoiceId);
}

$j(function() {
	// Add 'Print invoice' button for existing invoices
	if(!$j('[name=SelectedID]').val()) return;

	$j(
		'<div class="btn-group-vertical btn-group-lg vspacer-lg" style="width: 100%;">' +
			'<button type="button" class="btn btn-danger btn-lg" title="Will open invoice in new window. Please enable popups if prompted.">' +
			'<i class="glyphicon glyphicon-print"></i> Print Invoice</button>' +
		'</div>'
	)
	.on('click', printInvoice)
	.prependTo('#invoices_dv_action_buttons .btn-toolbar');
});

