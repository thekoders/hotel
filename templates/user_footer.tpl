<script src="js/jquery-2.2.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
<script src="js/morris.min.js"></script>
<script src="js/jquery.sparkline.min.js"></script>
<script src="js/jquery-jvectormap-1.2.2.min.js"></script>
<script src="js/jquery-jvectormap-world-mill-en.js"></script>
<script src="js/jquery.knob.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="js/bootstrap3-wysihtml5.all.min.js"></script>
<script src="js/jquery.slimscroll.min.js"></script>
<script src="js/fastclick.js"></script>
<script src="js/app.min.js"></script>
<script src="js/demo.js"></script>
<script src="js/daterangepicker.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/jquery.inputmask.js"></script>
<script src="js/jquery.inputmask.date.extensions.js"></script>
<script src="js/jquery.inputmask.extensions.js"></script>
<script src="js/select2.full.min.js"></script>
<script src="js/fileinput.js"></script>
<script src="js/fileinput.min.js"></script>

<script>
	$(function() {
	
		$("#room_cat").change(function() {
		  $("#room_no").load("ajax/room_by_category.php?choice=" + encodeURIComponent($("#room_cat").val()));
					
		});
	});
</script>

<script>
	$(function() {
	
		$("#meal_type").change(function() {
		  $("#meal").load("ajax/meal_by_meal_type.php?choice=" + encodeURIComponent($("#meal_type").val()));
					
		});
	});
</script>

