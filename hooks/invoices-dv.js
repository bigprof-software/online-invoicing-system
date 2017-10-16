
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



function addCommas(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}




$j(function () {
	$j('#subtotal, #total').prop('readonly', true);

	
	var update_subtotal = function () {

		var id = $j('[name=SelectedID]').val();
		$j.ajax({
			url: 'hooks/ajax-invoice-subtotal.php?id=' + id,
			type: 'get',
			cache: false,
			success: function (response) {
				$j('#subtotal').val(response)
				console.log("ok");
			},
		});



		if ($j("input[type='radio']#type1:checked").val() == "Tax") {
			var subtotal = $j('#subtotal').val().replace(/,/g, "");
			if ($j('#subtotal').val().length == 0) {

				var subtotal = "0.00";
			}
			console.log(subtotal);

			var discount = $j('#discount').val();
			console.log(discount)

			if (($j('#discount').val().length == 0)||(!$j.isNumeric(discount))) {

				discount = "0.00";
				
				
			}

			var tax = $j('#tax').val();
			console.log(tax)

				if (($j('#tax').val().length == 0)||(!$j.isNumeric(tax))) {

				tax = "0.00";
				
			}

		

			var total = parseFloat(subtotal) * (1 - parseFloat(discount) / 100) * (1 + parseFloat(tax) / 100);
			var n = total.toFixed(2);
			$j('#total').val(n);
			//$j('#total').change();
		} else {

			var subtotal = $j('#subtotal').val().replace(/,/g, "");
			if ($j('#subtotal').val().length == 0) {

				var subtotal = "0.00";

			}
			
			var tax = $j('#tax').val("0.00");
			console.log(tax)
			console.log(subtotal);
			var discount = $j('#discount').val();


			if (($j('#discount').val().length == 0)||(!$j.isNumeric(discount))) {

				discount = "0.00";
			}

		
			console.log(discount)
			var total = parseFloat(subtotal) * (1 - parseFloat(discount) / 100);
			var n = total.toFixed(2);
			$j('#total').val(n);
			//$j('#total').change();


		}


	};







	$j('#discount, #tax').on('change', function () {
		


		update_subtotal();
	});




	$j('#total').change();


	if ($j('[name=SelectedID]').val().length)
		setInterval(update_subtotal, 3000);

	update_subtotal();













});

