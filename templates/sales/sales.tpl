{include file="user_header.tpl"}
{include file="user_navigation.tpl"}

{literal}
<script>
	$(document).ready(function() {
		$('input.product').typeahead({
			name: 'product',
			remote: 'ajax/query_inventory.php?query=%QUERY'
		});
	})
</script>
{/literal}
<section class="content">
	<div class="nav-tabs-custom">
		<div class="tab-content">
			<div class="row">
				<div class="col-lg-9">
					<p><strong>Sales</strong></p>
				</div>
				<div class="col-lg-3">
					<a href="restaurant.php" class="btn btn-sm btn-danger col-lg-12">Back To Restaurant</a>
				</div>
			</div>
			<div class="row">
				{if $error_report=='on'}
					<div class="error_report" style="margin-bottom: 50px;">
						<strong>{$error_message}</strong>
					</div>
				{/if}
			</div>
			<div class="row">				
				<form name="select_item_form"  action="sales.php?job=select" method="post">

					<div class="col-lg-3">
                        <input type="text" class="form-control" name="meal_no" value="{$meal_no}" required placeholder="Meal No" tabindex="3"/>
                    </div>
					<div class="col-lg-4">
						<button type="submit"  class="btn btn-danger" name="ok" style="margin-right: 11px;" value="Submit"  tabindex="6">Submit</button>											
					</div>
                    <div class="col-lg-5"></div>
				</form>
			</div>
			<div class="row">
				<div class="col-lg-9">
					<table class="table table-bordered table-striped">
						<thead>
							<tr style="background-color: #e0e0e0;">
								<th>Delete</th>
								<th>Meal Name</th>
								<th>Price</th>
								<th>Quantity</th>
								<th>Total</th>
								<th>Update</th>
							</tr>
						</thead>
						<tbody>
							{php}list_item_by_sales($_SESSION['sales_no']);{/php}
							<tr style="background-color: #e0e0e0;">
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<td align="right"><strong>{$total}</strong></td>
								<th></th>
							</tr>
						</tbody>
					</table>

					<a href="sales.php?job=kot" class="btn btn-success">KOT</a>
				</div>

				<div class="col-lg-3" style="margin-top: 20px;">
					<form class="product" name="sales_form" action="sales.php?job=sales" method="post" >
						<input type="text" class="form-control" name="sales_no" value="{$sales_no}" required readonly="readonly" placeholder="Sales No" tabindex="3"/>
						<input type="text" class="form-control" name="customer_name" placeholder="Customer" tabindex="4"/>
						<select class="form-control"  name="discount_type" value = "{$dicount_type}" tabindex="1">
							<option value="" disabled selected>Discount Type</option>
							<option value="%" >Percentage(%)</option>
							<option value=".00" >Amount(.00)</option>
						</select>
						<input type="text" class="form-control" name="discount" placeholder="Discount" tabindex="5"/>
						<input type="text" class="form-control" name="prepared_by" value="{$prepared_by}" placeholder="Prepared by" required readonly="readonly"/>
						{if $edit_mode=='on'}
						<input type="text" class="form-control" name="updated_by" value="{$updated_by}" placeholder=" Updated by" required readonly="readonly"/>
						{/if}
						<select class="form-control"  name="service_charge" value = "{$service_charge}" tabindex="1">
							<option value="" disabled selected>Service Charge</option>
							<option value="Keep" >Keep</option>
							<option value="Skip" >Skip</option>
						</select>
						<select class="form-control"  name="payment" value = "{$payment}" tabindex="1">
							<option value="cash" >Cash</option>
							<option value="card" >Card</option>
                            <option value="pending" >Pending</option>
						</select>
						<div id="cus_amount"></div>
						<div id="balance"></div>
						<button  type="submit"  class="btn btn-success col-lg-12" name="ok" style="margin-right: 11px;" value="Save"  tabindex="6">Finish the Bill & Print</button>					
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

{include file="user_footer.tpl"}
