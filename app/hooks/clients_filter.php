<?php 
	if(!isset($Translation)){ @header('Location: index.php'); exit; }

	$advanced_search_mode = 0;
	$search_mode_session_key = substr('spm_' . basename(__FILE__), 0, -4);
	if(isset($_REQUEST['advanced_search_mode'])) {
		/* if user explicitly sets search mode by clicking Filter_x from the filters page, 
		 * apply requested mode, and store into session */
		$advanced_search_mode = intval($_REQUEST['advanced_search_mode']) ? 1 : 0;
		$_SESSION[$search_mode_session_key] = $advanced_search_mode;

	} elseif(isset($_SESSION[$search_mode_session_key])) {
		/* otherwise, check if search mode for given table is specified in user's 
		 * session and apply it */
		$advanced_search_mode = intval($_SESSION[$search_mode_session_key]) ? 1 : 0;
	}
?>

	<input type="hidden" name="advanced_search_mode" value="<?php echo $advanced_search_mode; ?>" id="advanced_search_mode">
	<script>
		$j(function(){
			$j('.btn.search_mode').appendTo('.page-header h1');
			$j('.btn.search_mode').click(function(){
				var mode = parseInt($j('#advanced_search_mode').val());
				$j('#advanced_search_mode').val(1 - mode);
				if(typeof(beforeApplyFilters) == 'function') beforeApplyFilters();
				return true;
			});
		})
	</script>

<?php if($advanced_search_mode){ ?>
	<button class="btn btn-lg btn-success pull-right search_mode" id="simple_search_mode" type="submit" name="Filter_x" value="1">Switch to simple search mode</button>
	<script>
		$j(function() {
			$j('#simple_search_mode').click(function() {
				if(!confirm('If you switch to simple search mode, any filters defined here will be lost! Do you still which to proceed?')) return false;
				$j('.clear_filter').click();
			})		
		})
	</script>
	<?php include(dirname(__FILE__) . '/../defaultFilters.php'); ?>
	
<?php }else{ ?>

	<button class="btn btn-lg btn-default pull-right search_mode" type="submit" name="Filter_x" value="1">Switch to advanced search mode</button>
			<!-- %datetimePicker% -->
			
			<div class="page-header"><h1>
				<a href="clients_view.php" style="text-decoration: none; color: inherit;">
					<img src="resources/table_icons/administrator.png"> 					Clients Filters</a>
			</h1></div>

				
	<div class="row vspacer-lg" style="border-bottom: dotted 2px #DDD;" >
		
		<div class="hidden-xs hidden-sm col-md-3 vspacer-lg text-right"><label for="">Email</label></div>
		<div class="hidden-md hidden-lg col-xs-12 vspacer-lg"><label for="">Email</label></div>
		
				
		<input type="hidden" name="FilterAnd[1]" value="and">
		<input type="hidden" name="FilterField[1]" value="9">  
		<input type="hidden" name="FilterOperator[1]" value="like">
		<div class="col-md-8 col-lg-6 vspacer-md">
			<input type="text" class="form-control" name="FilterValue[1]" value="<?php echo htmlspecialchars($FilterValue[1]); ?>" size="3">
		</div>
		
		
		<div class="col-xs-3 col-xs-offset-9 col-md-offset-0 col-md-1">
			<button type="button" class="btn btn-default vspacer-md btn-block" title='Clear fields' onclick="clearFilters($j(this).parent());" ><span class="glyphicon glyphicon-trash text-danger"></button>
		</div>

			</div>


		
			<!-- ########################################################## -->
					
	<div class="row vspacer-lg" style="border-bottom: dotted 2px #DDD;" >
		
		<div class="hidden-xs hidden-sm col-md-3 vspacer-lg text-right"><label for="">Phone</label></div>
		<div class="hidden-md hidden-lg col-xs-12 vspacer-lg"><label for="">Phone</label></div>
		
				
		<input type="hidden" name="FilterAnd[2]" value="and">
		<input type="hidden" name="FilterField[2]" value="8">  
		<input type="hidden" name="FilterOperator[2]" value="like">
		<div class="col-md-8 col-lg-6 vspacer-md">
			<input type="text" class="form-control" name="FilterValue[2]" value="<?php echo htmlspecialchars($FilterValue[2]); ?>" size="3">
		</div>
		
		
		<div class="col-xs-3 col-xs-offset-9 col-md-offset-0 col-md-1">
			<button type="button" class="btn btn-default vspacer-md btn-block" title='Clear fields' onclick="clearFilters($j(this).parent());" ><span class="glyphicon glyphicon-trash text-danger"></button>
		</div>

			</div>


		
			<!-- ########################################################## -->
			<?php
				$options = array("Afghanistan","Albania","Algeria","American Samoa","Andorra","Angola","Anguilla","Antarctica","Antigua, Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia, Herzegovina","Botswana","Bouvet Is.","Brazil","Brunei Darussalam","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Canary Is.","Cape Verde","Cayman Is.","Central African Rep.","Chad","Channel Islands","Chile","China","Christmas Is.","Cocos Is.","Colombia","Comoros","Congo, D.R. Of","Congo","Cook Is.","Costa Rica","Croatia","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Is.","Faroe Is.","Fiji","Finland","France","French Guiana","French Polynesia","French Territories","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guadeloupe","Guam","Guatemala","Guernsey","Guinea-bissau","Guinea","Guyana","Haiti","Heard, Mcdonald Is.","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Israel","Italy","Ivory Coast","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Korea, D.P.R Of","Korea, Rep. Of","Kuwait","Kyrgyzstan","Lao Peoples D.R.","Latvia","Lebanon","Lesotho","Liberia","Libyan Arab Jamahiriya","Liechtenstein","Lithuania","Luxembourg","Macao","Macedonia, F.Y.R Of","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Mariana Islands","Marshall Islands","Martinique","Mauritania","Mauritius","Mayotte","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherlands Antilles","Netherlands","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Niue","Norfolk Island","North Korea","Norway","Oman","Pakistan","Palau","Palestinian Terr.","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Pitcairn","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Russian Federation","Rwanda","Samoa","San Marino","Sao Tome, Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Is.","Somalia","South Africa","South Georgia","South Sandwich Is.","Spain","Sri Lanka","St. Helena","St. Kitts, Nevis","St. Lucia","St. Pierre, Miquelon","St. Vincent, Grenadines","Sudan","Suriname","Svalbard, Jan Mayen","Swaziland","Sweden","Switzerland","Syrian Arab Republic","Taiwan","Tajikistan","Tanzania","Thailand","Timor-leste","Togo","Tokelau","Tonga","Trinidad, Tobago","Tunisia","Turkey","Turkmenistan","Turks, Caicoss","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Viet Nam","Virgin Is. British","Virgin Is. U.S.","Wallis, Futuna","Western Sahara","Yemen","Yugoslavia","Zambia","Zimbabwe");
			
				//convert options to select2 format
				$optionsList = array();
				for ($i = 0; $i < count($options); $i++) {
					$optionsList[] = (object) array(
						"id" => $i,
						"text" => $options[$i]
					);
				}
				$optionsList = json_encode($optionsList);

			
				//convert value to select2 format
				if ($FilterValue[3]) {
					$filtervalueObj = new stdClass();
					$text = htmlspecialchars($FilterValue[3]);
					$filtervalueObj->text = $text;
					$filtervalueObj->id = array_search($text, $options);

					$filtervalueObj = json_encode($filtervalueObj);
				}

			?>	<div class="row vspacer-lg" style="border-bottom: dotted 2px #DDD;" >
		
		<div class="hidden-xs hidden-sm col-md-3 vspacer-lg text-right"><label for="">Country</label></div>
		<div class="hidden-md hidden-lg col-xs-12 vspacer-lg"><label for="">Country</label></div>
		
				
		<div class="col-md-8 col-lg-6 vspacer-md">	
			<div id="7_DropDown"><span></span></div>
		</div>
		<input type="hidden" class="populatedOptionsData" name="3" value="<?php echo htmlspecialchars($FilterValue[3]); ?>" >
		<input type="hidden" name="FilterAnd[3]" value="and">
		<input type="hidden" name="FilterField[3]" value="7">
		<input type="hidden" name="FilterOperator[3]" value="equal-to">
		<input type="hidden" name="FilterValue[3]" id="7_currValue" value="<?php echo htmlspecialchars($FilterValue[3]); ?>" size="3">

		
		<div class="col-xs-3 col-xs-offset-9 col-md-offset-0 col-md-1">
			<button type="button" class="btn btn-default vspacer-md btn-block" title='Clear fields' onclick="clearFilters($j(this).parent());" ><span class="glyphicon glyphicon-trash text-danger"></button>
		</div>

			</div>

	<script>
		var populate_7 = <?php echo $filtervalueObj ;?>		
		$j(function () {
			$j("#7_DropDown").select2({
				data: <?php echo $optionsList; ?>}).on('change', function (e) {
				$j("#7_currValue").val(e.added.text);
			});


			/* preserve the applied filter and show it when re-opening the filters page */
			if ($j("#7_currValue").val().length) {
				$j("#7_DropDown").select2('data', populate_7 );
			}
		});
	</script>
			
			<!-- ########################################################## -->
			
	<div class="row vspacer-lg" style="border-bottom: dotted 2px #DDD;" >
		
		<div class="hidden-xs hidden-sm col-md-3 vspacer-lg text-right"><label for="">Unpaid sales</label></div>
		<div class="hidden-md hidden-lg col-xs-12 vspacer-lg"><label for="">Unpaid sales</label></div>
		
					
		<div class="col-xs-3 col-md-1 vspacer-lg text-center">Between</div>
		<input type="hidden" name="FilterAnd[4]" value="and">
		<input type="hidden" name="FilterField[4]" value="12">   
		<input type="hidden" name="FilterOperator[4]" value="greater-than-or-equal-to">
		<div class="col-xs-9 col-md-3 col-lg-2 vspacer-md">
			<input type="text" class="numeric form-control" name="FilterValue[4]" value="<?php echo htmlspecialchars($FilterValue[4]); ?>" size="3">
		</div>

				<div class="col-xs-3 col-md-1 text-center vspacer-lg and"> and </div>
		<input type="hidden" name="FilterAnd[5]" value="and">
		<input type="hidden" name="FilterField[5]" value="12">  
		<input type="hidden" name="FilterOperator[5]" value="less-than-or-equal-to">
		<div class="col-xs-9 col-md-3 col-lg-2 vspacer-md">
			<input type="text" class="numeric form-control" name="FilterValue[5]" value="<?php echo htmlspecialchars($FilterValue[5]); ?>" size="3">
		</div>

		
		<div class="col-xs-3 col-xs-offset-9 col-md-offset-0 col-md-1">
			<button type="button" class="btn btn-default vspacer-md btn-block" title='Clear fields' onclick="clearFilters($j(this).parent());" ><span class="glyphicon glyphicon-trash text-danger"></button>
		</div>

			</div>

		
			<!-- ########################################################## -->
			
	<div class="row vspacer-lg" style="border-bottom: dotted 2px #DDD;" >
		
		<div class="hidden-xs hidden-sm col-md-3 vspacer-lg text-right"><label for="">Paid sales</label></div>
		<div class="hidden-md hidden-lg col-xs-12 vspacer-lg"><label for="">Paid sales</label></div>
		
					
		<div class="col-xs-3 col-md-1 vspacer-lg text-center">Between</div>
		<input type="hidden" name="FilterAnd[7]" value="and">
		<input type="hidden" name="FilterField[7]" value="13">   
		<input type="hidden" name="FilterOperator[7]" value="greater-than-or-equal-to">
		<div class="col-xs-9 col-md-3 col-lg-2 vspacer-md">
			<input type="text" class="numeric form-control" name="FilterValue[7]" value="<?php echo htmlspecialchars($FilterValue[7]); ?>" size="3">
		</div>

				<div class="col-xs-3 col-md-1 text-center vspacer-lg and"> and </div>
		<input type="hidden" name="FilterAnd[8]" value="and">
		<input type="hidden" name="FilterField[8]" value="13">  
		<input type="hidden" name="FilterOperator[8]" value="less-than-or-equal-to">
		<div class="col-xs-9 col-md-3 col-lg-2 vspacer-md">
			<input type="text" class="numeric form-control" name="FilterValue[8]" value="<?php echo htmlspecialchars($FilterValue[8]); ?>" size="3">
		</div>

		
		<div class="col-xs-3 col-xs-offset-9 col-md-offset-0 col-md-1">
			<button type="button" class="btn btn-default vspacer-md btn-block" title='Clear fields' onclick="clearFilters($j(this).parent());" ><span class="glyphicon glyphicon-trash text-danger"></button>
		</div>

			</div>

		
			<!-- ########################################################## -->
			
	<div class="row vspacer-lg" style="border-bottom: dotted 2px #DDD;" >
		
		<div class="hidden-xs hidden-sm col-md-3 vspacer-lg text-right"><label for="">Total sales</label></div>
		<div class="hidden-md hidden-lg col-xs-12 vspacer-lg"><label for="">Total sales</label></div>
		
					
		<div class="col-xs-3 col-md-1 vspacer-lg text-center">Between</div>
		<input type="hidden" name="FilterAnd[10]" value="and">
		<input type="hidden" name="FilterField[10]" value="14">   
		<input type="hidden" name="FilterOperator[10]" value="greater-than-or-equal-to">
		<div class="col-xs-9 col-md-3 col-lg-2 vspacer-md">
			<input type="text" class="numeric form-control" name="FilterValue[10]" value="<?php echo htmlspecialchars($FilterValue[10]); ?>" size="3">
		</div>

				<div class="col-xs-3 col-md-1 text-center vspacer-lg and"> and </div>
		<input type="hidden" name="FilterAnd[11]" value="and">
		<input type="hidden" name="FilterField[11]" value="14">  
		<input type="hidden" name="FilterOperator[11]" value="less-than-or-equal-to">
		<div class="col-xs-9 col-md-3 col-lg-2 vspacer-md">
			<input type="text" class="numeric form-control" name="FilterValue[11]" value="<?php echo htmlspecialchars($FilterValue[11]); ?>" size="3">
		</div>

		
		<div class="col-xs-3 col-xs-offset-9 col-md-offset-0 col-md-1">
			<button type="button" class="btn btn-default vspacer-md btn-block" title='Clear fields' onclick="clearFilters($j(this).parent());" ><span class="glyphicon glyphicon-trash text-danger"></button>
		</div>

			</div>

		
			<!-- ########################################################## -->
			    

			<!-- sorting header  -->   
			<div class="row" style="border-bottom: solid 2px #DDD;">
				<div class="col-md-offset-2 col-md-8 vspacer-lg"><strong>Order by</strong></div>
			</div>
			
			<!-- sorting rules -->
			<?php
			// Fields list
			$sortFields = new Combo;
			$sortFields->ListItem = $this->ColCaption;
			$sortFields->ListData = $this->ColNumber;

			// sort direction
			$sortDirs = new Combo;
			$sortDirs->ListItem = array("ascending" , "descending" );
			$sortDirs->ListData = array("asc", "desc");
			$num_rules = min(maxSortBy, count($this->ColCaption));

			for($i = 0; $i < $num_rules; $i++){
				$sfi = $sd = "";
				if(isset($orderBy[$i])) foreach($orderBy[$i] as $sfi => $sd);

				$sortFields->SelectName = "OrderByField$i";
				$sortFields->SelectID = "OrderByField$i";
				$sortFields->SelectedData = $sfi;
				$sortFields->SelectedText = "";
				$sortFields->Render();

				$sortDirs->SelectName = "OrderDir$i";
				$sortDirs->SelectID = "OrderDir$i";
				$sortDirs->SelectedData = $sd;
				$sortDirs->SelectedText = "";
				$sortDirs->Render();

				$border_style = ($i == $num_rules - 1 ? "solid 2px #DDD" : "dotted 1px #DDD");
				?>
				
				<!-- sorting rule -->
				<div class="row" style="border-bottom: <?php echo $border_style; ?>;">
					<div class="col-xs-2 vspacer-md hidden-md hidden-lg"><strong><?php echo ($i ? "then by" : "order by"); ?></strong></div>
					<div class="col-md-2 col-md-offset-2 vspacer-md hidden-xs hidden-sm text-right"><strong><?php echo ($i ? "then by" : "order by"); ?></strong></div>
					<div class="col-xs-6 col-md-4 vspacer-md"><?php echo $sortFields->HTML; ?></div>
					<div class="col-xs-4 col-md-2 vspacer-md"><?php echo $sortDirs->HTML; ?></div>
				</div>
				<?php
			}
			?>			<!-- filter actions -->
			<div class="row">
				<div class="col-md-3 col-md-offset-3 col-lg-offset-4 col-lg-2 vspacer-lg">
					<input type="hidden" name="apply_sorting" value="1">
					<button type="submit" id="applyFilters" onclick="beforeApplyFilters(event);return true;" class="btn btn-success btn-block btn-lg"><i class="glyphicon glyphicon-ok"></i> Apply filters</button>
				</div>
									<div class="col-md-3 col-lg-2 vspacer-lg">
						<button type="submit" onclick="beforeApplyFilters(event);return true;" class="btn btn-default btn-block btn-lg" id="SaveFilter" name="SaveFilter_x" value="1"><i class="glyphicon glyphicon-align-left"></i> Save &amp; apply filters</button>
					</div>
								<div class="col-md-3 col-lg-2 vspacer-lg">
					<button onclick="beforeCancelFilters();" type="submit" id="cancelFilters" class="btn btn-warning btn-block btn-lg"><i class="glyphicon glyphicon-remove"></i> Cancel</button>
				</div>
			</div>

			<script>
				$j(function(){
					//stop event if it is already bound
					$j(".numeric").off("keydown").on("keydown", function (e) {
						// Allow: backspace, delete, tab, escape, enter and .
						if ($j.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
							// Allow: Ctrl+A, Command+A
							(e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
							// Allow: home, end, left, right, down, up
							(e.keyCode >= 35 && e.keyCode <= 40)) {
								// let it happen, don't do anything
								return;
						}
						// Ensure that it is a number and stop the keypress
						if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
							e.preventDefault();
						}
					});                
				});
				
				/* function to handle the action of the clear field button */
				function clearFilters(elm){
					var parentDiv = $j(elm).parent(".row ");
					//get all input nodes
					inputValueChildren = parentDiv.find("input[type!=radio][name^=FilterValue]");
					inputRadioClildren = parentDiv.find("input[type=radio][name^=FilterValue]");
					
					//default input nodes ( text, hidden )
					inputValueChildren.each(function( index ) {
						$j( this ).val('');
					});
					
					//radio buttons
					inputRadioClildren.each(function( index ) {
						$j( this ).removeAttr('checked');

						//checkbox case
						if ($j( this ).val()=='') $j(this).attr("checked", "checked").click();
					});
					
					//lookup and select dropdown
					parentDiv.find("div[id$=DropDown],div[id^=filter_]").select2("val", "");

					//for lookup
					parentDiv.find("input[id^=lookupoperator_]").val('equal-to');

				}
				
				function checkboxFilter(elm) {
					if (elm.value == "null") {
						$j("#" + elm.className).val("is-empty");
					} else {
						$j("#" + elm.className).val("equal-to");
					}
				}
				
				/* funtion to remove unsupplied fields */
				function beforeApplyFilters(event){
				
					//get all field submitted values
					$j(":input[type=text][name^=FilterValue],:input[type=hidden][name^=FilterValue],:input[type=radio][name^=FilterValue]:checked").each(function( index ) {
						  
						//if type=hidden  and options radio fields with the same name are checked, supply its value
						if ( $j( this ).attr('type')=='hidden' &&  $j(":input[type=radio][name='"+$j( this ).attr('name')+"']:checked").length >0 ){
							return;
						}
						  
						  //do not submit fields with empty values
						if ( !$j( this ).val()){
						  var fieldNum =  $j(this).attr('name').match(/(\d+)/)[0];
						  $j(":input[name='FilterField["+fieldNum+"]']").val('');
						 
						  };
					});

				}
				
				function beforeCancelFilters(){
					

					//other fields
					$j('form')[0].reset();

					//lookup case ( populate with initial data)
					$j(":input[class='populatedLookupData']").each(function(){
					  

						$j(":input[name='FilterValue["+$j(this).attr('name')+"]']").val($j(this).val());
						if ($j(this).val()== '<None>'){
							$j(this).parent(".row ").find('input[id^="lookupoperator"]').val('is-empty');
						}else{
							$j(this).parent(".row ").find('input[id^="lookupoperator"]').val('equal-to');
						}
							
					})

					//options case ( populate with initial data)
					$j(":input[class='populatedOptionsData']").each(function(){
					   
						$j(":input[name='FilterValue["+$j(this).attr('name')+"]']").val($j(this).val());
					})


					//checkbox, radio options case
					$j(":input[class='checkboxData'],:input[class='optionsData'] ").each(function(){
						var filterNum = $j(this).val();
						var populatedValue = eval("filterValue_"+filterNum);                  
						var parentDiv = $j(this).parent(".row ");

						//check old value
						parentDiv.find("input[type=radio][value='"+populatedValue+"']").attr('checked', 'checked').click();
					
					})

					//remove unsuplied fields
					beforeApplyFilters();

					return true;
				}
			</script>
			
			<style>
				.form-control{ width: 100% !important; }
				.select2-container, .select2-container.vspacer-lg{ max-width: unset !important; width: 100%; margin-top: 0 !important; }
			</style>


		

<?php } ?>