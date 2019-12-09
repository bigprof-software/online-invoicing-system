$j(function() {
	/* add button to copy catalog price */
	AppGini.insertButtonAfterFormControl({
		fieldName: 'catalog_price',
		buttonText: 'Copy to unit price',
		icon: 'duplicate',
		buttonClickHandler: function() {
			var cp = $j('#catalog_price').text();
			var up = $j('input[id="unit_price"]');

			up.focus();
			if(up.val() == cp) return;

			up.val(cp).change();
		}
	})
})