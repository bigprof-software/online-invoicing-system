/**
* function to redirect to the selected print invoice template
* @return void
*/
function print_invoice_tax() {
	var selected_id = $j('[name=SelectedID]').val();

	/**
	* @var template string the name of the template (changing the selected option to lower case then *replacing spaces with underscores)
	*/
	var option = $j("#invoice_template").val();
	
	if(option.trim() != ""){
		var template = option.toLowerCase().replace(/\s/g, '_') + ".php";
		window.location = "hooks/invoice-templates/" + template + "?id=" + selected_id;
	}else{
		alert('you should select template to print');
	}
}

function show_error(field, msg) {
	modal_window({
		message: '<div class="alert alert-danger">' + msg + '</div>',
		title: 'Error in ' + field,
		close: function () {
			$j('#' + field).focus();
			$j('#' + field).parents('.form-group').addClass('has-error');
		}
	});

	return false;
}


/**
 *  @brief formats numbers with thousands separators
 */
function addCommas(nStr)
{
	nStr += '';
	var x = nStr.split('.'),
		x1 = x[0],
		x2 = (x.length > 1 ? '.' + x[1] : ''),
		rgx = /(\d+)(\d{3})/;

	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}

	return x1 + x2;
}


$j(function () {
	var selected_id = $j('[name=SelectedID]').val();

	if(selected_id){
		/* Show 'Print invoice' button */
		$j('#invoices_dv_action_buttons .btn-toolbar').append(
			'<div class="btn-group-vertical btn-group-lg" style="width: 100%;">' +
				'<button type="button" class="btn btn-default btn-lg" onclick="print_invoice_tax()">' +
				'<i class="glyphicon glyphicon-print"></i> Print Invoice</button>' +
			'</div>'
		);
	} else {
		$j('#total').val("0.00");
	}

	$j('#subtotal, #total').prop('readonly', true);

	
	var update_subtotal = function () {
		if(selected_id){
			$j.ajax({
				url: 'hooks/ajax-invoice-subtotal.php?id=' + selected_id,
				type: 'get',
				cache: false,
				success: function (response) {
					$j('#subtotal').val(response);
				},
			});
		}


		var subtotal = $j('#subtotal').val().replace(/,/g, "");
		if(!parseFloat(subtotal)) subtotal = "0.00";

		var discount = $j('#discount').val();
		if(!parseFloat(discount)) discount = "0.00";

		var tax = $j('#tax').val();
		if(!parseFloat(tax)) tax = "0.00";

		var total = parseFloat(subtotal) * (1 - parseFloat(discount) / 100) * (1 + parseFloat(tax) / 100);
		$j('#total').val(total.toFixed(2));
	};

	$j('#discount, #tax').on('change', update_subtotal);

	if(selected_id){
		setInterval(update_subtotal, 2000);
		update_subtotal();
	}
});

