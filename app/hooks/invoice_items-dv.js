
function show_error(field, msg){
	modal_window({
		message: '<div class="alert alert-danger">' + msg + '</div>',
		title: 'Error in ' + field,
		close: function(){
			$j('#' + field).focus();
			$j('#' + field).parents('.form-group').addClass('has-error');
		}
	});
	
	return false;
}





$j(function(){
	
	/* Set subtotal field as read-only to avoid user editing */
	$j('#price').prop('readonly', true);
        
        $j('#unit_price').prop('readonly', true);
        
        
       
         var update_subtotal = function(){
     $j('#item-container').on('change',function(){
                var id= $j('#item-container').val();
                console.log(id);
            $j.ajax({
                url:'hooks/ajax-unit-price.php?id='+id,
                type:'get',
                cache:false,

                success:  function (response) {
                    console.log(response);
                    $j('#unit_price').val(response)
                    console.log("ok");
                },              
        });
   
        })
	}
        
	
          update_subtotal();
        
        
	/* recalculate subtotal on updating unit price, quantity or discount */
	$j('#unit_price, #qty').change(function(){
		var UnitPrice = $j('#unit_price').val();
                 console.log(isNaN(UnitPrice))
                 if(isNaN(UnitPrice)){
			return show_error('unit_price', 'The unit_price should be number');
		}
                
		var Quantity = $j('#qty').val();
                 if(isNaN(Quantity)){
			return show_error('unit_price', 'The unit_price should be number');
		}
                
		var Subtotal =  parseFloat(UnitPrice) * parseFloat(Quantity);
		$j('#price').val(Subtotal);
	});
	
	/* Calculate Subtotal on opening the detail view form */
	$j('#price').change();
})