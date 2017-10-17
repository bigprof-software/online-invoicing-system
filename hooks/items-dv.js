$j(function(){
	// continue only if insert/update allowed
	if(!$j('#update').length && !$j('#insert').length) return;
	var item_id = $j('[name=SelectedID]').val();
	if(!item_id) return;
	
	// update last price every 2 seconds
	var request_running = false; // prevent new requests if one already running
	setInterval(function(){
		if(request_running) return;
		
		request_running = true;
		$j('#unit_price').load(
			'hooks/ajax-last-price.php', {
				item_id: item_id
			},
			function(){
				request_running = false;
			}
		);
	}, 2000);
})