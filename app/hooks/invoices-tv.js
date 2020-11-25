/* start of mass_update code */
var massUpdateAlert = function(msg, showOk, okClass) {
	if(showOk == undefined) showOk = false;
	if(okClass == undefined) okClass = 'default';

	var footer = [];
	if(showOk) footer.push({ label: massUpdateTranslation.ok, bs_class: okClass });

	$j('.modal').modal('hide');
	var mId = modal_window({ message: '', title: msg, footer: footer });
	$j('#' + mId).find('.modal-body').remove();
	if(!footer.length) $j('#' + mId).find('.modal-footer').remove();
}


/* Mark as paid command */
function massUpdateCommand_1nvkk0q0ckqc7b8migay(tn, ids) {

	/* ask user for confirmation before applying updates */
	if(!confirm(massUpdateTranslation.areYouSureApply)) return;

	massUpdateAlert(massUpdateTranslation.pleaseWait);

	$j.ajax({
		url: "hooks\/ajax-mass-update-invoices-status-1nvkk0q0ckqc7b8migay.php",
		data: { ids: ids },
		success: function() { location.reload(); },
		error: function() {
			massUpdateAlert('<span class="text-danger">' + massUpdateTranslation.error + '</span>', true, 'danger');
		}
	});

}

/* Mark as cancelled command */
function massUpdateCommand_xe0xlisfn56ps9sp3p76(tn, ids) {

	/* ask user for confirmation before applying updates */
	if(!confirm(massUpdateTranslation.areYouSureApply)) return;

	massUpdateAlert(massUpdateTranslation.pleaseWait);

	$j.ajax({
		url: "hooks\/ajax-mass-update-invoices-status-xe0xlisfn56ps9sp3p76.php",
		data: { ids: ids },
		success: function() { location.reload(); },
		error: function() {
			massUpdateAlert('<span class="text-danger">' + massUpdateTranslation.error + '</span>', true, 'danger');
		}
	});

}
/* end of mass_update code */

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