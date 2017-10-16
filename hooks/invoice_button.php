<?php
$currDir = dirname(__FILE__) . '/..';
define('PREPEND_PATH', '../');
include("$currDir/defaultLang.php"); //1
include("$currDir/language.php"); //2
include("$currDir/lib.php"); //3
// this is the core file of the appGini
include_once("$currDir/header.php");

/* first and last year for year drop down */
$first_year = substr(sqlValue("select min(date_due) from invoices"), 0, 4);
$last_year = substr(sqlValue("select max(date_due) from invoices"), 0, 4);
?>

<link rel="stylesheet" href="resources/bootstrap-datepicker/css/bootstrap-datepicker3.min.css">
<script src="resources/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<?php
echo '<div style="height:60px;">' . '</div>';

echo '<div class="btn-group-vertical btn-group-lg" style="width: 100%;">' .
 '<button id="search_by_customer" type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#myModal">' .
 '<i class="glyphicon glyphicon-search"></i> Search by Customer Name</button>' .
 '</div>';

echo '<div style="height:60px;">' . '</div>';


echo '<div class="btn-group-vertical btn-group-lg" style="width: 100%;">' .
 '<button type="button" class="btn btn-default btn-lg" onclick="print_invoice()">' .
 '<i class="glyphicon glyphicon-search"></i> All due invoices</button>' .
 '</div>';


echo '<div style="height:60px;">' . '</div>';

echo '<div class="btn-group-vertical btn-group-lg" style="width: 100%;">' .
 '<button type="button" class="btn btn-default btn-lg" onclick="print_invoice2()">' .
 '<i class="glyphicon glyphicon-search"></i> All Upcoming invoices</button>' .
 '</div>';

echo '<div style="height:60px;">' . '</div>';

echo '<div class="btn-group-vertical btn-group-lg" style="width: 100%;">' .
 '<button type="button" class="btn btn-default btn-lg" onclick="print_invoice3()">' .
 '<i class="glyphicon glyphicon-search"></i> All Over Due invoices</button>' .
 '</div>';




echo '<div style="height:60px;">' . '</div>';

echo '<div class="btn-group-vertical btn-group-lg" style="width: 100%;">' .
 '<button type="button" class="btn btn-default btn-lg" onclick="print_invoice4()">' .
 '<i class="glyphicon glyphicon-search"></i> Upcoming And  Due invoices</button>' .
 '</div>';


echo '<div style="height:60px;">' . '</div>';

echo '<div class="btn-group-vertical btn-group-lg" style="width: 100%;">' .
 '<button id="search_by_year" type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#myModal3">' .
 '<i class="glyphicon glyphicon-search"></i> Search by year</button>' .
 '</div>';






include_once("$currDir/footer.php"); // include the footer file
?>

<script>
	function print_invoice() {

		window.location = 'due_invoices.php'; // hna hwdeh l sf7a tnya bs b3tlha el orser id
	}
	function print_invoice2() {

		window.location = 'upcoming_invoices.php'; // hna hwdeh l sf7a tnya bs b3tlha el orser id
	}

	function print_invoice3() {

		window.location = 'overdue_invoices.php'; // hna hwdeh l sf7a tnya bs b3tlha el orser id
	}
	
		function print_invoice4() {

		window.location = 'upcoming_and_due_invoices.php'; // hna hwdeh l sf7a tnya bs b3tlha el orser id
	}
</script>



<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Search All invoice of a certain customer </h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <form action="search_by_name.php" method="get">
                        <div class="form-group">
                            Search Customer Name :  <select name="search"  id="CategoryDropDown"> 
								<?php
								$customer_name = sql("select id ,name from clients ", $e0);
								echo "<option value=' '> </option>";
                                
								while ($row = mysqli_fetch_assoc($customer_name)) {
									echo  "<option value='" . $row ['id'] . "'>" . $row['name'] . "</option>";
								}
								?>
                            </select>  <br><br>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Search</button>
                        </div>
                    </form>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="myModal3" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Search By Year </h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <form action="search_by_year.php" method="post">

                        <div class="form-group">
                            Search By Year : 
                            <select id="year" name="search"></select>
                            <br><br>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Search</button>
                        </div>
                    </form>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>








<script>

	var start = <?php echo $first_year; ?>;
	var end = <?php echo $last_year; ?>;
	var options = "<option value=''> </option>";
	var year = 0;
	for (year = start; year <= end; year++) {
		options += '<option value=' + year + '>' + year + "</option>";
	}
	document.getElementById("year").innerHTML = options

	$j(function () {


		$j('#CategoryDropDown').select2();
		$j('#year').select2();

		<?php if(isset($_REQUEST['search_by_customer'])){ ?>
			$j('#search_by_customer').click();
		<?php } ?>

		<?php if(isset($_REQUEST['search_by_year'])){ ?>
			$j('#search_by_year').click();
		<?php } ?>

	})
</script>




<script>
	$j(function () {
		$j('#from-date, #to-date').datepicker({
			autoclose: false,
			format: 'yyyy-mm-dd',
			orientation: 'down'
		});

		$j('#from-date').change(function () {
			$j('#to-date').datepicker('setStartDate', $j('#from-date').val());

			var df = new Date($j('#from-date').datepicker('getDate'));
			df.setMonth(df.getMonth() + 1);
			$j('#to-date').datepicker('setDate', df);
		});
	})
</script>


<style>
    #from-date, #to-date{ display: inline !important; }
</style>