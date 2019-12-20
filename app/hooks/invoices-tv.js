$j(function() {
	/* highlight unpaid invoices in table view */
	$j('td.invoices-status').each(function() {
		var td = $j(this);
		if(td.text() != 'Unpaid') return;

		var tr = td.parents('tr');
		var dueDateTd = tr.find('.invoices-date_due');
		var dueDate = moment(dueDateTd.text(), AppGini.datetimeFormat());
		var today = moment().format('YYYY-MM-DD');

	    if(dueDate.isBefore(today)) {
			tr.addClass('danger');
			tr.find('a').addClass('text-danger');
			td.find('a').addClass('text-bold');
	    } else if(dueDate.isSame(today)) {
			tr.addClass('warning');
			tr.find('a').addClass('text-warning text-bold');
	    }
	})	
})