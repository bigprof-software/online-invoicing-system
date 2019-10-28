<?php
	$rdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'invoices';

		/* data for selected record, or defaults if none is selected */
		var data = {
			client: <?php echo json_encode(array('id' => $rdata['client'], 'value' => $rdata['client'], 'text' => $jdata['client'])); ?>,
			client_contact: <?php echo json_encode($jdata['client_contact']); ?>,
			client_address: <?php echo json_encode($jdata['client_address']); ?>,
			client_phone: <?php echo json_encode($jdata['client_phone']); ?>,
			client_email: <?php echo json_encode($jdata['client_email']); ?>,
			client_website: <?php echo json_encode($jdata['client_website']); ?>,
			client_comments: <?php echo json_encode($jdata['client_comments']); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for client */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'client' && d.id == data.client.id)
				return { results: [ data.client ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for client autofills */
		cache.addCheck(function(u, d) {
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'client' && d.id == data.client.id) {
				$j('#client_contact' + d[rnd]).html(data.client_contact);
				$j('#client_address' + d[rnd]).html(data.client_address);
				$j('#client_phone' + d[rnd]).html(data.client_phone);
				$j('#client_email' + d[rnd]).html(data.client_email);
				$j('#client_website' + d[rnd]).html(data.client_website);
				$j('#client_comments' + d[rnd]).html(data.client_comments);
				return true;
			}

			return false;
		});

		cache.start();
	});
</script>

