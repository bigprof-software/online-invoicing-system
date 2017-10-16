<?php

// For help on using hooks, please refer to http://bigprof.com/appgini/help/working-with-generated-web-database-application/hooks

function invoice_items_init(&$options, $memberInfo, &$args) {

	return TRUE;
}

function invoice_items_header($contentType, $memberInfo, &$args) {
	$header = '';

	switch ($contentType) {
		case 'tableview':
			$header = '';
			break;

		case 'detailview':
			$header = '';
			break;

		case 'tableview+detailview':
			$header = '';
			break;

		case 'print-tableview':
			$header = '';
			break;

		case 'print-detailview':
			$header = '';
			break;

		case 'filters':
			$header = '';
			break;
	}

	return $header;
}

function invoice_items_footer($contentType, $memberInfo, &$args) {
	$footer = '';

	switch ($contentType) {
		case 'tableview':
			$footer = '';
			break;

		case 'detailview':
			$footer = '';
			break;

		case 'tableview+detailview':
			$footer = '';
			break;

		case 'print-tableview':
			$footer = '';
			break;

		case 'print-detailview':
			$footer = '';
			break;

		case 'filters':
			$footer = '';
			break;
	}

	return $footer;
}

function invoice_items_before_insert(&$data, $memberInfo, &$args) {

	return TRUE;
}

function invoice_items_after_insert($data, $memberInfo, &$args) {


	return TRUE;
}

function invoice_items_before_update(&$data, $memberInfo, &$args) {

	return TRUE;
}

function invoice_items_after_update($data, $memberInfo, &$args) {

	return TRUE;
}

function invoice_items_before_delete($selectedID, &$skipChecks, $memberInfo, &$args) {

	return TRUE;
}

function invoice_items_after_delete($selectedID, $memberInfo, &$args) {
	
}

function invoice_items_dv($selectedID, $memberInfo, &$html, &$args) {
	global $Translation;
	if (isset($_REQUEST['dvprint_x']))
		return;

	ob_start();
	?>

	<script>
		$j(function () {
	<?php if (!$selectedID) { ?>
				$j('#qty').val("0");
				setTimeout(function () {
					$j('#deselect').removeClass('btn-warning').addClass('btn-default').get(0).lastChild.data = '<?php echo $Translation['Back']; ?>';
				}, 1000);

	<?php }else{ ?>
	setTimeout(function () {
					$j('#deselect').removeClass('btn-warning').addClass('btn-default').get(0).lastChild.data = '<?php echo $Translation['Back']; ?>';
				}, 1000);
	<?php }?>
		});


	</script>

	<?php
	$form_code = ob_get_contents();
	ob_end_clean();

	$html .= $form_code;
}

function invoice_items_csv($query, $memberInfo, $args) {

	return $query;
}
