<script>
	$j(function() {
		AppGini = AppGini || {};
		/**
		 * inserts a button after (right to) a form element
		 *
		 * @param      object  options  { fieldName, buttonText, icon, buttonClickHandler }
		 */
		AppGini.insertButtonAfterFormControl = function(options) {
			var elm = $j('#' + options.fieldName),
				parent = elm.parent(),
				label = $j('label[for="' + options.fieldName + '"]');

			/* hack for fixing label alignment in various screen sizes :/ */
			label.clone()
				.addClass('col-xs-12 visible-xs-block')
				.css('text-align', 'left')
				.insertAfter(label);
			label.clone()
				.addClass('col-sm-12 visible-sm-block visible-md-block')
				.css('text-align', 'left')
				.insertAfter(label);
			label.addClass('visible-lg-block');

			parent.removeClass('col-lg-9').addClass('col-xs-2 col-sm-1');

			var btnContainer = $j('<div class="col-xs-4"></div>');
			var btn = $j(
				'<button type="button" class="btn btn-default">' +
					(options.icon ? '<i class="glyphicon glyphicon-' + options.icon + '"></i> ' : '') +
					options.buttonText +
				'</button>'
			);

			btn.click(options.buttonClickHandler).appendTo(btnContainer);
			btnContainer.insertAfter(parent);
		}
	})
</script>