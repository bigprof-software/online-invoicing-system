<?php
	$rdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'invoice_items';

		/* data for selected record, or defaults if none is selected */
		var data = {
			invoice: <?php echo json_encode(array('id' => $rdata['invoice'], 'value' => $rdata['invoice'], 'text' => $jdata['invoice'])); ?>,
			item: <?php echo json_encode(array('id' => $rdata['item'], 'value' => $rdata['item'], 'text' => $jdata['item'])); ?>,
			current_price: <?php echo json_encode($jdata['current_price']); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for invoice */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'invoice' && d.id == data.invoice.id)
				return { results: [ data.invoice ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for item */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'item' && d.id == data.item.id)
				return { results: [ data.item ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for item autofills */
		cache.addCheck(function(u, d) {
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'item' && d.id == data.item.id) {
				$j('#current_price' + d[rnd]).html(data.current_price);
				return true;
			}

			return false;
		});

		cache.start();
	});
</script>

