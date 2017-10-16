<?php

$dir = 'invoice-templates';
$options = 'invoices.invoice_template.csv';
$templates = glob($dir . '/*.php');

file_put_contents($options, '');

foreach ($templates as $template) {
	file_put_contents($options, basename($template).';;', FILE_APPEND);	
}