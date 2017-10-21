<?php

// For help on using hooks, please refer to http://bigprof.com/appgini/help/working-with-generated-web-database-application/hooks


/**
 *
 * function to load templates from invoice templates folder
 *	then store them in csv file as option list
 */

function load_invoice_templates(){
	$dir = 'hooks/invoice-templates';
	$options = 'hooks/invoices.invoice_template.csv';
	$templates = glob($dir . '/*.php');
	$list = [];

	if($templates){
		foreach ($templates as $template) {
			$list[] = ucwords(str_replace('.php', '', str_replace('_', ' ', basename($template))));
		}
	}

	file_put_contents($options, implode(';;', $list));
}

function invoices_init(&$options, $memberInfo, &$args) {
	load_invoice_templates();
	return TRUE;
}

function invoices_header($contentType, $memberInfo, &$args) {
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

function invoices_footer($contentType, $memberInfo, &$args) {
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

function invoices_before_insert(&$data, $memberInfo, &$args) {

	return TRUE;
}

function invoices_after_insert($data, $memberInfo, &$args) {

	return TRUE;
}

function invoices_before_update(&$data, $memberInfo, &$args) {

	return TRUE;
}

function invoices_after_update($data, $memberInfo, &$args) {

	return TRUE;
}

function invoices_before_delete($selectedID, &$skipChecks, $memberInfo, &$args) {

	return TRUE;
}

function invoices_after_delete($selectedID, $memberInfo, &$args) {
	
}

function invoices_dv($selectedID, $memberInfo, &$html, &$args) {
	global $Translation;
	
	/* define all Translation strings needed by js code */
	ob_start();
	?>
	<script>
		window.Translation = window.Translation || {};
		window.Translation['back'] = '<?php echo html_attr($Translation['Back']); ?>';
	</script>
	<?php
	$form_code = ob_get_contents();
	ob_end_clean();

	$html .= $form_code;
}

function invoices_csv($query, $memberInfo, $args) {

	return $query;
}
