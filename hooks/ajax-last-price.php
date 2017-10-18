<?php
	$curr_dir = dirname(__FILE__);
	include("{$curr_dir}/../defaultLang.php");
	include("{$curr_dir}/../language.php");
	include("{$curr_dir}/../lib.php");

	restrict_access('items');
	
	$item_id = max(0, intval($_REQUEST['item_id']));
	if(!$item_id){ die; }
	
	echo update_item_latest_price($item_id);
