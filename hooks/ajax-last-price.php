<?php
	$curr_dir = dirname(__FILE__);
	include("{$curr_dir}/../defaultLang.php");
	include("{$curr_dir}/../language.php");
	include("{$curr_dir}/../lib.php");
	
	/* check access */
	$mi = getMemberInfo();
	if(!$mi['group']){ die; }
	
	$item_id = max(0, intval($_REQUEST['item_id']));
	if(!$item_id){ die; }
	
	echo update_item_latest_price($item_id);
