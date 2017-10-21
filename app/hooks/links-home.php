<?php
	/*
	 * You can add custom links in the home page by appending them here ...
	 * The format for each link is:
		$homeLinks[] = array(
			'url' => 'path/to/link', 
			'title' => 'Link title', 
			'description' => 'Link text',
			'groups' => array('group1', 'group2'), // groups allowed to see this link, use '*' if you want to show the link to all groups
			'grid_column_classes' => '', // optional CSS classes to apply to link block. See: http://getbootstrap.com/css/#grid
			'panel_classes' => '', // optional CSS classes to apply to panel. See: http://getbootstrap.com/components/#panels
			'link_classes' => '', // optional CSS classes to apply to link. See: http://getbootstrap.com/css/#buttons
			'icon' => 'path/to/icon' // optional icon to use with the link
		);
	 */


	$year = date("Y");
	$month = date("m");

	$sql = "SELECT COUNT(id) FROM invoices WHERE status='Unpaid' AND MONTH(date_due)='%s' AND YEAR(date_due)='%s'";
	$due = sqlValue(sprintf($sql, $month, $year), $error); // due
	$upcoming = sqlValue(sprintf($sql, ++$month, $year), $error); // due

	$homeLinks[] = array(
		'url' => 'hooks/reports.php', 
		'title' => 'Reports', 
		'description' => '<div id="reports-section"></div>',
		'groups' => array('*'), // groups allowed to see this link, use '*' if you want to show the link to all groups
		'grid_column_classes' => 'col-md-12', // optional CSS classes to apply to link block. See: http://getbootstrap.com/css/#grid
		'panel_classes' => 'panel-info', // optional CSS classes to apply to panel. See: http://getbootstrap.com/components/#panels
		'link_classes' => 'btn-info', // optional CSS classes to apply to link. See: http://getbootstrap.com/css/#buttons
		'icon' => 'resources/table_icons/attributes_display.png' // optional icon to use with the link
	);

?>

<div id="reports-draft" class="hidden">
	<a class="btn btn-warning stat" href="hooks/due_invoices.php">
		<span class="badge"><?php echo $due; ?></span>
		Due invoices 
	</a>
	<a class="stat btn btn-info" href="hooks/upcoming_invoices.php">
		<span class='badge'><?php echo $upcoming;?></span>
		Upcoming invoices 
	</a> 
</div>

<script>
	$j(function(){
		$j('#reports-section').html($j('#reports-draft').html());
		$j('#reports-draft').remove();
	})
</script>


