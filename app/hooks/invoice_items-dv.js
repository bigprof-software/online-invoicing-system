$j(function() {
	/* if this is not a new record, skip */
	if($j('[name="SelectedID"]').val()) return;

	/* hide 'catalog price' field */
	$j('#catalog_price').parents('.form-group').addClass('hidden');

	/* add button to copy current price if record editable */
	if(!$j('#insert').length) return;
	AppGini.insertButtonAfterFormControl({
		fieldName: 'current_price',
		buttonText: 'Copy to unit price',
		icon: 'duplicate',
		buttonClickHandler: function() {
			var cp = $j('#current_price').text().trim();
			var up = $j('input[id="unit_price"]');

			up.focus();
			if(up.val() == cp) return;

			up.val(cp).change();
		}
	})
})

$j(function() {
	/* if this is not an existing record, skip */
	if(!$j('[name="SelectedID"]').val()) return;

	/* add button to copy catalog price if record editable */
	if(!$j('#update').length) return;
	AppGini.insertButtonAfterFormControl({
		fieldName: 'catalog_price',
		buttonText: 'Copy to unit price',
		icon: 'duplicate',
		buttonClickHandler: function() {
			var cp = $j('#catalog_price').text().trim();
			var up = $j('input[id="unit_price"]');

			up.focus();
			if(up.val() == cp) return;

			up.val(cp).change();
		}
	})
})