<?php

function last_incomplete_bill(){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result=mysqli_query($conn, "SELECT * FROM bar_sales_has_items WHERE `cancel_status` = 0 AND `saved` = 0 ORDER BY `bar_sales_no` ASC LIMIT 1");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{

		echo'<div class="col-lg-3"><strong>Bar sales No: </strong>'.$row[bar_sales_no].'</div>
			 <div class="col-lg-5"><strong>Bar sales Time: </strong>'.$row[on_update].'</div>
			 <div class="col-lg-4"><strong>Table No: </strong>'.$row[ref_no].'</div>
			
			<table class="table table-bordered table-striped">
			<thead>
				<tr style="background-color: #e0e0e0;">
					<th>Delete</th>
					<th>Liquor Name</th>
					<th>Price</th>
					<th>Quantity</th>
					<th>Total</th>
					<th>Update</th>
				</tr>
			</thead>
			<tbody>';
		$result1=mysqli_query($conn, "SELECT * FROM bar_sales_has_items WHERE bar_sales_no='$row[bar_sales_no]' AND cancel_status='0' ORDER BY id ASC");
		while($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC))
		{
			echo'<tr height="50">
			<form name="update_item" action="bar_sales.php?job=update_item&liquor_id='.$row1[liquor_id].'&bar_sales_no='.$row[bar_sales_no].'" method="post">
				<td align="center"><a href="bar_sales.php?job=delete_item&id='.$row1[id].'" ><button class="btn btn-sm btn-danger">Delete</button></a></td>'."
				<td>".$row1[liquor]."</td>
				<td align='right'><input type='text' name='price' value=".$row1[price]." size='10' style='color: #000; font: 14px/30px Arial, Helvetica, sans-serif; height: 25px; line-height: 25px; border: 1px solid #d5d5d5; padding: 0 4px; text-align: right;' readonly/></td>
				<td align='right'><input type='text' name='quantity' value=".$row1[quantity]." size='6' style='color: #000; font: 14px/30px Arial, Helvetica, sans-serif; height: 25px; line-height: 25px; border: 1px solid #d5d5d5; padding: 0 4px; text-align: right;'/></td>
				<td align='right'>".$row1[total]."</td>
				<td align='right'><input type='submit' name='update' value='Update' size='9' class='btn btn-sm btn-success'/></td>
			</form></tr>";
		}
		$total=get_total_bar_sales($row['bar_sales_no']);
		echo'<tr height="30">
				<td colspan="4" style="background-color: #e0e0e0;"><a href="bar_sales.php?job=complete_bar_sales&bar_sales_no='.$row[bar_sales_no].'"><div class="col-lg-12 btn btn-primary">Complete Bill</div></a></td>
				<td align="right" style="background-color: #e0e0e0;">'.$total.'</td>				
				<td align="right" style="background-color: #e0e0e0;"></td>
			</tr>
			</tbody>
		</table>';
			
	}
	include 'conf/closedb.php';
}

function all_incomplete_bill(){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result=mysqli_query($conn, "SELECT * FROM bar_sales_has_items WHERE `cancel_status` = 0 AND `saved` = 0 ORDER BY `bar_sales_no` ASC LIMIT 1, 100");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$total=get_total_bar_sales($row['bar_sales_no']);
		echo'<div class="col-lg-6 col-xs-12" style=" margin-left: -12px;">
				<div class="info-box">
			
					<a href="bar_sales.php?job=complete_bar_sales&bar_sales_no=' . $row [bar_sales_no] . '"  >
						<span class="info-box-icon bg-green">'.$row['bar_sales_no'].'</span>
					</a>
								
					<div class="info-box-content">
					
						<p style="line-height: 18px; margin-bottom: -10px;">
							<strong>Time: </strong>'.$row[on_update].'<br />';
							if($row[order_type]=="Order From Room"){
								echo'<strong>Room: </strong>'.$row[ref_no].'<br />';
							}
							elseif($row[order_type]=="Dine In"){
								echo'<strong>Table: </strong>'.$row[ref_no].'<br />';
							}
							else{
								
								echo'<strong>Take Away</strong><br />';
							}
							
							echo'<strong>Total: </strong>'.$total.'
						</p>
					</div>
				</div>
			</div>';
			
	}
	include 'conf/closedb.php';
}

function list_item_by_bar_sales($bar_sales_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM bar_sales_has_items WHERE bar_sales_no='$bar_sales_no' AND cancel_status='0' ORDER BY id ASC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo'<tr>
		<form name="update_item" action="bar_sales.php?job=update_item&liquor_id='.$row[liquor_id].'" method="post">
            <td align="center" ><a href="bar_sales.php?job=delete_item&id='.$row[id].'" ><img src="images/close.png" alt="Delete" /></a></td>'."
            <td>".$row[liquor]."</td>
            <td align='right'><input type='text' name='price' value=".$row[price]." size='10' style='color: #000; font: 14px/30px Arial, Helvetica, sans-serif; height: 25px; line-height: 25px; border: 1px solid #d5d5d5; padding: 0 4px; text-align: right;' readonly/></td>
            <td align='right'><input type='text' name='quantity' value=".$row[quantity]." size='6' style='color: #000; font: 14px/30px Arial, Helvetica, sans-serif; height: 25px; line-height: 25px; border: 1px solid #d5d5d5; padding: 0 4px; text-align: right;'/></td>
            <td align='right'>".$row[total]."</td>
            <td align='right'><input type='submit' name='update' value='Update' size='9' class='more' style='width: 70px; border: 0; padding: 1.5px;'/></td>
		</form></tr>";
	}
	include 'conf/closedb.php';

}


function get_total_bar_sales($bar_sales_no){
	include 'conf/config.php';
	include 'conf/opendb.php';


	$result=mysqli_query($conn, "SELECT sum(total) as total FROM bar_sales_has_items WHERE bar_sales_no='$bar_sales_no' AND cancel_status='0'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$total=$row[total];
	}

	return $total;

	include 'conf/closedb.php';
}

function add_bar_sales_item($selected_item, $size, $stock, $price, $bar_sales_no, $item_total, $order_type, $ref_no, $booking_ref){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$date = date("Y-m-d");

	$query = "INSERT INTO bar_sales_has_items (id, liquor_id, liquor, size, price, date, bar_sales_no, quantity, user_name, total, order_type, ref_no, booking_ref)
	VALUES ('', '$selected_item', '$stock', '$size', '$price', '$date', '$bar_sales_no', '1', '$_SESSION[user_name]', '$item_total', '$order_type', '$ref_no', '$booking_ref')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}

function check_non_saved_bar_sales_order($user_name){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT count(id) FROM bar_sales_has_items WHERE user_name='$user_name' AND saved='0'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		if ($row['count(id)'] >=1) {
			return 1;
		}
		else{
			return 0;
		}
	}

	include 'conf/closedb.php';
}

function non_save_bar_sales_info($user_name){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT MIN(bar_sales_no) FROM bar_sales_has_items WHERE user_name='$user_name' AND saved='0'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row['MIN(bar_sales_no)'];
	}

	include 'conf/closedb.php';
}

function get_bar_sales_no(){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT MAX(bar_sales_no) FROM bar_sales_has_items");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row['MAX(bar_sales_no)']+1;
	}

	include 'conf/closedb.php';
}

function check_added_items($id, $bar_sales_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT count(id) FROM bar_sales_has_items WHERE id='$id' AND bar_sales_no='$bar_sales_no' AND cancel_status='0'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		if ($row['count(id)'] >=1) {
			return 1;
		}
		else{
			return 0;
		}
	}

	include 'conf/closedb.php';
}

function update_bar_sales_item($id, $quantity, $item_total, $price, $bar_sales_no){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$query = "UPDATE bar_sales_has_items SET
	quantity='$quantity',
	price='$price',
	total='$item_total',
	saved='0'
	WHERE liquor_id='$id' AND cancel_status='0' AND bar_sales_no='$bar_sales_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function update_bar_sales_item_for_repeative_adding($id, $quantity, $item_total){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$query = "UPDATE bar_sales_has_items SET
	quantity='$quantity',
	total='$item_total',
	saved='0'
	WHERE liquor_id='$id' AND cancel_status='0'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function get_quantity($vehicle_id, $bar_sales_no){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result=mysqli_query($conn, "SELECT sum(quantity) as tot FROM bar_sales_has_items WHERE vehicle_id='$vehicle_id' AND bar_sales_no='$bar_sales_no' AND cancel_status='0'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$total=$row[tot];

	}

	return $total;

	include 'conf/closedb.php';
}


function print_bar_sales_item($bar_sales_no){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo'<table style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
		<tr>
			<th>Qty</th>
			<th>Description</th>
			<td align="right"><strong>U.Price</strong></td>
			<td align="right"><strong>Amount</strong></td>
		</tr>';
	
	$result=mysqli_query($conn, "SELECT * FROM bar_sales_has_items WHERE bar_sales_no='$bar_sales_no' AND cancel_status='0' ORDER BY id ASC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		
		$total=($row[quantity]*$row[price]);
		echo'<tr>		
		<td>'.$row[quantity].'</td>
		<td>'.$row[liquor].'</td>
		<td align="right">'.$row[price].'</td>
		<td align="right">'.number_format($total,2).'</td>
		</tr>';
		$grand_total+=$total;			
	}
	
	$result1=mysqli_query($conn, "SELECT * FROM bar_sales WHERE bar_sales_no='$bar_sales_no'");
	while($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC))
	{
		$discount = $row1['discount'];
		$discount_type=$row1['discount_type'];
		if($row1['discount_type']=="%"){
			$discount_amount = $row1['total']-($row1['total']*($row1['discount']/100)) ;
			$dis=$row1['total']*($row1['discount']/100);
		}
		else{
			$discount_amount = $row1['total']-$row1['discount'];
			$dis=$row1['discount'];
		}
		$_SESSION['service_charge']=$row1['service_charge'];
	}	
	echo'<tr  style="line-height: 30px;">
            <td></td>
            <td>Total</td>
			<td></td>
            <td align="right">'.number_format($grand_total,2).'</td>
        </tr>';
		if($discount){
			echo'<tr  style="line-height: 30px;">
					<td></td>
					<td>Discount('.$discount.''.$discount_type.')</td>
					<td></td>
					<td align="right">('.number_format($dis,2).')</td>
				</tr>';
		}
		else{
			echo'<tr  style="line-height: 30px;">
					<td></td>
					<td>Discount(0%)</td>
					<td></td>
					<td align="right">(0.00)</td>
				</tr>';
		}
		
		if($_SESSION[service_charge]=="Skip"){
			
			$result2=mysqli_query($conn, "SELECT * FROM tax WHERE percentage!='0' AND tax_type!='Service Charge'");
		}
		else{
			$result2=mysqli_query($conn, "SELECT * FROM tax WHERE percentage!='0'");
		}
		
		while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC))
		{
			$tax_total = $discount_amount*($row2[percentage]/100);
			
			echo'<tr  style="line-height: 30px;">
					<td></td>
					<td>'.$row2[tax_type].'('.$row2[percentage].'%)</td>
					<td></td>
					<td align="right">'.number_format($tax_total,2).'</td>
				</tr>';
			$full_total += $tax_total;
			$net_total = $full_total + $discount_amount;
		}
		echo'<tr  style="line-height: 30px;">
            <td></td>
            <td>Grand Total</td>
			<td></td>
            <td align="right">'.number_format($net_total,2).'</td>
        </tr>';

			
			$query = "UPDATE bar_sales SET
			amount_after_discount = '$discount_amount',
			net_total ='$net_total'
			WHERE bar_sales_no='$bar_sales_no'";
			mysqli_query($conn, $query);
			

	echo'</table>';
	
	unset($_SESSION['service_charge']);
	include 'conf/closedb.php';


}

function net_total($bar_sales_no){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$net_total=0;

	$result=mysqli_query($conn, "SELECT * FROM bar_sales_has_items WHERE bar_sales_no='$bar_sales_no' AND cancel_status='0' ORDER BY id ASC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$total=$row[quantity]*$row[selling_price];
		$net_total=$net_total+$total;

	}

	return $net_total;

	include 'conf/closedb.php';
}

function get_liquor_info_from_bar_sales_has_items($id, $bar_sales_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM bar_sales_has_items WHERE liquor_id='$id' AND bar_sales_no='$bar_sales_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	include 'conf/closedb.php';
}

function get_liquor_info_from_bar_sales_has_items_by_id($id){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM bar_sales_has_items WHERE id='$id'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	include 'conf/closedb.php';
}

function cancel_item($id){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$query = "UPDATE bar_sales_has_items SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]',
	saved='0'
	WHERE id='$id'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function update_saved_bar_sales($bar_sales_no){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$query = "UPDATE bar_sales_has_items SET
	saved='1'
	WHERE bar_sales_no='$bar_sales_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}


function save_bar_sales($bar_sales_no, $date, $customer_name,$discount_type, $discount, $payment,$prepared_by, $remarks, $total, $order_type, $ref_no, $booking_ref, $service_charge){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$date = date("Y-m-d");
	
	$query = "INSERT INTO bar_sales (id, bar_sales_no, customer_name, discount_type, discount, prepared_by, remarks, date, total, due, order_type, ref_no, booking_ref, service_charge,payment)
	VALUES ('', '$bar_sales_no', '$customer_name','$discount_type','$discount', '$prepared_by', '$remarks', '$date', '$total', '$total', '$order_type', '$ref_no', '$booking_ref', '$service_charge', '$payment')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}


function list_bar_sales_search($bar_sales_no_search, $customer_search){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if($bar_sales_no_search && $customer_search){
		$and="AND ";
	}
	else{
		$and="";
	}
	
	if($bar_sales_no_search){
		$bar_sales_no_check="bar_sales_no LIKE '%$bar_sales_no_search'";
	}
	else{
		$bar_sales_no_check="";
	}

	if($customer_search){
		$customer_check="customer_name='$customer_search'";
	}
	else{
		$customer_check="";
	}
	
	if($bar_sales_no_search || $customer_search){
	
	echo '<table class="inventory_table" style="width: 900px; border-bottom: 2px solid silver; margin-bottom: 30px; margin-top: 0x;">
	<thead valign="top">
	<th>Edit</th>
	<th>Print</th>
	<th>Bar_sales No</th>
	<th>Bar_sales Date</th>
	<th>Customer Name</th>
	<th>Bar_sales Total</th>
	<th>Remarks</th>
	<th>Prepared By</th>
	<th>Delete</th>
	</thead>
	<tbody valign="top">';

	$result=mysqli_query($conn, "SELECT * FROM bar_sales WHERE $customer_check $and $bar_sales_no_check AND cancel_status='0' ORDER BY id DESC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
			<td><a href="bar_sales.php?job=edit&id='.$row[id].'"  ><img src="images/edit.png" alt="Edit" /></a></td>

			<td><a href="bar_sales.php?job=print_preview&id='.$row[id].'"  ><img src="images/print.png" alt="Print" width="24" height="24" /></a></td>
			
			<td>'.$row[bar_sales_no].'</td>
					
			<td>'.$row[date].'</td>
					
			<td>'.$row[customer_name].'</td>
			
			<td align="right">'.$row[total].'</td>
		
			<td align="center">'.$row[remarks].'</td>
			
			<td>'.strtoupper($row[prepared_by]).'</td>
		
			<td><a href="#" onclick="javascript:showConfirm(\'Are you sure you want to delete this entry?\',\'\',\'Yes\',\'bar_sales.php?job=delete&id='.$row[id].'\',\'No\',\'bar_sales.php?job=search\')"><img src="images/close.png" alt="Delete" /></a></td>
		</tr>';
	}
	echo '</tbody></table>';
	}
	
	include 'conf/closedb.php';
}


function list_bar_sales_search_report($customer_search, $bar_sales_no_search){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if($bar_sales_no_search && $customer_search){
		$and="AND ";
	}
	else{
		$and="";
	}
	
	if($bar_sales_no_search){
		$bar_sales_no_check="bar_sales_no='$bar_sales_no_search'";
	}
	else{
		$bar_sales_no_check="";
	}

	if($customer_search){
		$customer_check="customer_name='$customer_search'";
	}
	else{
		$customer_check="";
	}
	
	if($bar_sales_no_search || $customer_search){
	
	echo '<table class="inventory_table" style="width: 900px; border-bottom: 2px solid silver; margin-bottom: 30px; margin-top: 0x;">
	<thead valign="top">
	<th>No</th>
	<th>Bar_sales No</th>
	<th>Bar_sales Date</th>
	<th>Customer Name</th>
	<th>Bar_sales Total</th>
	<th>Due</th>
	<th>Paid</th>
	<th>Remarks</th>
	<th>Prepared By</th>
	</thead>
	<tbody valign="top">';
$i=1;
	$result=mysqli_query($conn, "SELECT * FROM bar_sales WHERE $customer_check $and $bar_sales_no_check AND cancel_status='0' ORDER BY id DESC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
		<td>'.$i.'</td>
			<td>'.$row[bar_sales_no].'</td>
					
			<td>'.$row[date].'</td>
					
			<td>'.$row[customer_name].'</td>
			
			<td align="right">'.$row[total].'</td>
		<td align="right">'.$row[due].'</td>
			<td align="right">'.$row[paid].'</td>
			<td align="center">'.$row[remarks].'</td>
			
			<td>'.strtoupper($row[prepared_by]).'</td>
		
			</tr>';
		$i++;
	
	
	$total=$total+$row[total];
	$due_total=$due_total+$row[due];
	$paid_total=$paid_total+$row[paid];
	}
	
	echo '<tr><th colspan="4">Total</th><th>'.number_format($total, 2).'</th><th>'.number_format($due_total, 2).'</th><th>'.number_format($paid_total, 2).'</th></tr></tbody></table>';
	}
	
	include 'conf/closedb.php';
}

function list_bar_sales(){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
		echo '<table class="inventory_table" style="width: 900px; border-bottom: 2px solid silver; margin-bottom: 30px; margin-top: 0x;">
	<thead valign="top">
	<th>No</th>
	<th>Bar_sales No</th>
	<th>Bar_sales Date</th>
	<th>Customer Name</th>
	<th>Bar_sales Total</th>
	<th>Due</th>
	<th>Paid</th>
	<th>Remarks</th>
	<th>Prepared By</th>
	</thead>
	<tbody valign="top">';

	$i=1;
	$result=mysqli_query($conn, "SELECT * FROM bar_sales WHERE cancel_status='0' ORDER BY id DESC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
			<td>'.$i.'</td>
			<td>'.$row[bar_sales_no].'</td>
					
			<td>'.$row[date].'</td>
					
			<td>'.$row[customer_name].'</td>
			
			<td align="right">'.$row[total].'</td>
			<td align="right">'.$row[due].'</td>
			<td align="right">'.$row[paid].'</td>
			<td align="center">'.$row[remarks].'</td>
			
			<td>'.strtoupper($row[prepared_by]).'</td>
		
			</tr>';
	$i=$i+1;
	$total=$total+$row[total];
	$due_total=$due_total+$row[due];
	$paid_total=$paid_total+$row[paid];
	}
	
	echo '<tr><th colspan="4">Total</th><th>'.number_format($total, 2).'</th><th>'.number_format($due_total, 2).'</th><th>'.number_format($paid_total, 2).'</th></tr></tbody></table>';
	
	
	
	include 'conf/closedb.php';
}

function get_bar_sales_info($id){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM bar_sales WHERE id='$id'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	include 'conf/closedb.php';
}

function get_bar_sales_info_by_bar_sales_no($bar_sales_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM bar_sales WHERE bar_sales_no='$bar_sales_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	include 'conf/closedb.php';
}

function get_order_type_info($bar_sales_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM bar_sales_has_items WHERE bar_sales_no='$bar_sales_no' AND cancel_status='0' ORDER BY `bar_sales_no` ASC LIMIT 1");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	include 'conf/closedb.php';
}

function get_booking_ref_for_restaurant_order($room_no){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$today=date('Y-m-d');

	$result=mysqli_query($conn, "SELECT * FROM room_has_status WHERE room_no='$room_no' AND date='$today'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row['booking_ref'];
	}
	include 'conf/closedb.php';
}


function get_bar_sales_info_booking_ref($booking_ref){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM bar_sales WHERE booking_ref='$booking_ref'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	include 'conf/closedb.php';
}



function update_bar_sales($id, $bar_sales_no, $date, $customer_name, $prepared_by, $remarks, $total, $updated_by){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$date = date("Y-m-d");

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE bar_sales SET
	bar_sales_no='$bar_sales_no',
	date='$date',
	customer_name='$customer_name',
	customer_amount='$customer_amount',
	prepared_by='$prepared_by',
	remarks='$remarks',
	total='$total',
	due='$total',
	updated_by='$updated_by' 
	WHERE id='$id'";

	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function  calncel_items_for_bar_sales_no($bar_sales_no){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE bar_sales_has_items SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]',
	saved='1'
	WHERE bar_sales_no='$bar_sales_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function cancel_bar_sales($id){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE bar_sales SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]'
	WHERE id='$id'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function get_bar_sales_item_id($bar_sales_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT MAX(id) FROM bar_sales_has_items WHERE  cancel_status='0' ");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row['MAX(id)'];
	}

	include 'conf/closedb.php';
}

function update_stock_bar_sales($bar_sales_no){
	include 'conf/config.php';
	include 'conf/opendb.php';
	

	$result=mysqli_query($conn, "SELECT * FROM bar_sales_has_items WHERE sales_no='$bar_sales_no' AND cancel_status='0'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$info=get_store_info($row[liquor]);
		$new_qty=$info['qty']-$row['quantity'];
		
		$query = "UPDATE store SET
		qty='$new_qty'
		WHERE item='$row[liquor]'";
		mysqli_query($conn, $query);
	}



	include 'conf/closedb.php';
}

function get_bar_sales_info_by_sales_no($bar_sales_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM bar_sales WHERE sales_no='$bar_sales_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	include 'conf/closedb.php';
}

function get_product_info_from_bar_sales_has_items($id, $bar_sales_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM bar_sales_has_items WHERE liquor_id='$id' AND bar_sales_no='$bar_sales_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	include 'conf/closedb.php';
}
