{include file="user_header.tpl"}
{include file="user_navigation.tpl"}
{literal}
	
<script type="text/javascript">
$(function() {
	
	//autocomplete
	$(".auto").autocomplete({
		source: "ajax/query_inventory.php",
		minLength: 1
	});				

});
</script>

<script type="text/javascript">
$(function() {
	
	//autocomplete
	$(".auto1").autocomplete({
		source: "ajax/query_suppliers.php",
		minLength: 1
	});				

});
</script>

{/literal}



	
	<div id="contents">
	
		{if $error_report=='on'}
		<div class="error_report">
			<strong>{$error_message}</strong>
		</div>
		{/if}
		{if $warning_report=='on'}
		<div class="warning_report" style="margin-bottom: 50px;">
			<strong>{$warning_message}</strong>
		</div>
		{/if}
		
		
 	<section class="content">
  		  <div class="nav-tabs-custom">
  			  <div class="tab-content">
   				 <div class="row">
     			   <div class="col-lg-12" align="center">
                    
					</div>

					<section class="invoice">
						<div class="row">
        					<div class="col-xs-12">
          						<h2 class="page-header">
            					<i class="fa fa-globe"></i> Room Information 
          						</h2>
        					</div>
      					</div>
		
						<div class="row">
        					<div class="col-xs-12">
          						<form action="booking.php?job=booking_form_room_status&room_no={$room_no}&room_cat={$room_type}&from_date={$from_date}&to_date={$to_date}" method="post">
									<div class="row" style="margin-bottom: 10px;">
										<div class="col-lg-4">									
											<input class="form-control" type="text" name="telephone_num" value="{$telephone_num}" required placeholder="Telephone Number">
										</div>                                
										<div class="col-lg-3">
											<button type="submit" name="ok" value="Save" class="btn btn-block btn-success">Book this room</button>
										</div>
									</div>
								</form>
        					</div>
      					</div>

            					
  
      					<div class="row invoice-info">
         					<div class="col-sm-12 invoice-col">
								{php}list_room_information($_SESSION['room_no']);{/php}
        					</div>

							<div class="col-sm-12 invoice-col">

							</div> 
   
      					</div>

    				</section>

							
            	</div>   
        	</div>
		</div>	
	</div>
</section>
{include file="user_footer.tpl"}

	{literal}
	
			<script>
			 $(function () {
				 $("#example1").DataTable();
			 });
		</script>
	{/literal}