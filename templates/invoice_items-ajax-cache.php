<script>
	$j(function(){
		var tn = 'invoice_items';

		/* data for selected record, or defaults if none is selected */
		var data = {
			invoice: { id: '<?php echo $rdata['invoice']; ?>', value: '<?php echo $rdata['invoice']; ?>', text: '<?php echo $jdata['invoice']; ?>' },
			item: { id: '<?php echo $rdata['item']; ?>', value: '<?php echo $rdata['item']; ?>', text: '<?php echo $jdata['item']; ?>' }
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for invoice */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'invoice' && d.id == data.invoice.id)
				return { results: [ data.invoice ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for item */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'item' && d.id == data.item.id)
				return { results: [ data.item ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

