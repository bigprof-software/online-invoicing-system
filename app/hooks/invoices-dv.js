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



/* Inserted by Calendar plugin on 2020-11-25 19:05:54 */
(function($j) {
	var urlParam = function(param) {
		var url = new URL(window.location.href);
		return url.searchParams.get(param);
	};

	var setDate = function(dateField, date, time) {
		var dateEl = $j('#' + dateField);
		if(!dateEl.length) return; // no date field present

		var d = date.split('-').map(parseFloat).map(Math.floor); // year-month-day
		
		// if we have a date field with day and month components
		if($j('#' + dateField + '-mm').length && $j('#' + dateField + '-dd').length) {
			dateEl.val(d[0]);
			$j('#' + dateField + '-mm').val(d[1]);
			$j('#' + dateField + '-dd').val(d[2]);
			return;
		}

		// for datetime fields that have datetime picker, populate with formatted date and time
		if(dateEl.parents('.datetimepicker').length == 1) {
			dateEl.val(
				moment(date + ' ' + time).format(AppGini.datetimeFormat('dt'))
			);
			return;
		}

		// otherwise, try to populate date and time as-is
		dateEl.val(date + ' ' + time);
	};

	$j(function() {
		// continue only if this a new record form
		if($j('[name=SelectedID]').val()) return;

		var params = ['newEventType', 'startDate', 'startTime', 'endDate', 'endTime', 'allDay'], v = {};
		for(var i = 0; i < params.length; i++)
			v[params[i]] = urlParam('calendar.' + params[i]);

		// continue only if we have a newEventType param
		if(v.newEventType === null) return;

		// continue only if event start and end specified
		if(v.startDate === null || v.endDate === null) return;

		// adapt event data types
		v.allDay = JSON.parse(v.allDay);
		v.start = new Date(v.startDate + ' ' + v.startTime);
		v.end = new Date(v.endDate + ' ' + v.endTime);

		// now handle various event types, populating the relevent fields
		switch(v.newEventType) {
			case 'unpaid-invoice':
				setDate('date_due', v.startDate, v.startTime);
				break;
		}

		// finally, trigger user-defined event handlers
		$j(function() { 
			$j(document).trigger('newCalendarEvent', [v]); 
		})
	});
})(jQuery);
/* End of Calendar plugin code */

