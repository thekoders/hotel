<?php
function check_non_saved_purchase_order($user_name){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT count(id) FROM purchase_order_has_items WHERE user_name='$user_name' AND saved='0'");
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



function get_purchase_no(){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT MAX(purchase_order_no) FROM purchase_order_has_items");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row['MAX(purchase_order_no)']+1;
	}

	include 'conf/closedb.php';
}

function save_purchase_item($purchase_order_no,$purchase_item,$quantity,$buying_price,$user_name,$measure_type){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$date = date("Y-m-d");
    if($measure_type=='g'){
        $total = ($quantity/1000)*$buying_price;
        
    }
    else{
        $total = $quantity*$buying_price;
    }
	
	$query = "INSERT INTO purchase_order_has_items (id,purchase_item, quantity, measure_type, buying_price, date, purchase_order_no, user_name, total)
	VALUES ('','$purchase_item', '$quantity','$measure_type', '$buying_price', '$date', '$purchase_order_no', '$user_name', '$total')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}

function list_item_by_purchase_order($purchase_order_no){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	
		echo'<div class="box-body"> 
			<table style="width:100%" class=" table-responsive table-bordered table-striped dt-responsive">
				<thead>
					<tr>
					  <th>Items</th>
					  <th>Quantity</th>
					  <th>Buying price</th>
					  <th>Total</th>
					  <th>Delete</th>
					</tr>
				</thead>
				<tbody>';
	$result=mysqli_query($conn, "SELECT * FROM purchase_order_has_items WHERE purchase_order_no='$purchase_order_no' AND cancel_status='0'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo'
		<tr>
		<td>'.$row[purchase_item].'</td>
		<td>'.$row[quantity].''.$row[measure_type].'</td>
		<td>'.$row[buying_price].'</td>
		<td align="right">'.$row[total].'</td>
		<td ><a href="purchase_order.php?job=delete_item&id='.$row[id].'" ><img src="images/close.png" alt="Delete" /></a></td>
		</tr>';
        $grand_total= $grand_total+$row[total];
       
	}
    echo '<tr>
            <td colspan="3" align="right" class="success"><strong>Total</strong></td>
            <td align="right" class="success"><strong>' . number_format ($grand_total, 2 ) . '</strong></td>
			
        </tr>';
        
	echo'</tbody></table></div>';
	
	include 'conf/closedb.php';
}

function delete_purchase_item($id){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$query = "UPDATE purchase_order_has_items SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]'
	WHERE id='$id'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function update_saved($purchase_order_no){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	
	$query = "UPDATE purchase_order_has_items SET
	saved='1'
	WHERE purchase_order_no='$purchase_order_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function get_total($purchase_order_no){
	include 'conf/config.php';
	include 'conf/opendb.php';


	$result=mysqli_query($conn, "SELECT sum(total) as total FROM purchase_order_has_items WHERE purchase_order_no='$purchase_order_no' AND cancel_status='0'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$total=$row[total];
	}

	return $total;

	include 'conf/closedb.php';
}

function update_stock($purchase_order_no){
	include 'conf/config.php';
	include 'conf/opendb.php';


	$result=mysqli_query($conn, "SELECT * FROM purchase_order_has_items WHERE purchase_order_no='$purchase_order_no' AND cancel_status='0'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$info=get_store_info($row[purchase_item]);
		$new_qty=$info['qty']+$row['quantity'];
		
		$query = "UPDATE store SET
		qty='$new_qty'
		WHERE item='$row[purchase_item]'";
		mysqli_query($conn, $query);
	}



	include 'conf/closedb.php';
}


function save_purchase_order($purchase_order_no, $supplier_name, $prepared_by, $total){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$date = date("Y-m-d");
	
	
	$query = "INSERT INTO purchase_order (id, purchase_order_no, supplier_name, prepared_by, date, total)
	VALUES ('', '$purchase_order_no', '$supplier_name', '$prepared_by', '$date', '$total')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}

function list_purchase_order_search($purchase_order_no_search, $supplier_search){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if($purchase_order_no_search && $supplier_search){
		$and="AND ";
	}
	else{
		$and="";
	}
	
	if($purchase_order_no_search){
		$purchase_order_no_check="purchase_order_no LIKE '%$purchase_order_no_search'";
	}
	else{
		$purchase_order_no_check="";
	}

	if($supplier_search){
		$suppier_check="supplier_name='$supplier_search'";
	}
	else{
		$suppier_check="";
	}
	
	if($purchase_order_no_search || $supplier_search){
	
	echo '<div class="box-body"> 
			<table style="width: 80%;" class=" table-responsive table-bordered table-striped dt-responsive" cellspacing="0">
				<thead valign="top">
	<th>Edit</th>
	<th>Print</th>
	<th>Purchase Order No</th>
	<th>Purchase Order Date</th>
	<th>Suppier Name</th>
	<th>Purchase Total</th>
	<th>Remarks</th>
	<th>Prepared By</th>
	<th>Delete</th>
	</thead>
	<tbody valign="top">';

	$result=mysqli_query($conn, "SELECT * FROM purchase_order WHERE $suppier_check $and $purchase_order_no_check AND cancel_status='0' ORDER BY id DESC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
			<td><a href="purchase_order.php?job=edit&id='.$row[id].'"  ><img src="images/edit.png" alt="Edit" /></a></td>

			<td><a href="purchase_order.php?job=print_preview&id='.$row[id].'"  ><img src="images/print.png" alt="Print" width="24" height="24" /></a></td>
			
			<td>'.$row[purchase_order_no].'</td>
					
			<td>'.$row[date].'</td>
					
			<td>'.$row[supplier_name].'</td>
			
			<td align="right">'.$row[total].'</td>
		
			<td>'.$row[remarks].'</td>
			
			<td>'.strtoupper($row[prepared_by]).'</td>
		
			<td><a href="#" onclick="javascript:showConfirm(\'Are you sure you want to delete this entry?\',\'\',\'Yes\',\'purchase_order.php?job=delete&id='.$row[id].'\',\'No\',\'purchase_order.php?job=search\')"><img src="images/close.png" alt="Delete" /></a></td>
		</tr>';
	}
	echo '</tbody></table></div>';
	}
	
	include 'conf/closedb.php';
}

function list_purchase_orders(){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<table class="inventory_table" style="width: 900px; border-bottom: 2px solid silver; margin-bottom: 10px;">
	<thead valign="top">
	<th>Edit</th>
	<th>Print</th>
	<th>Purchase Order No</th>
	<th>Purchase Order Date</th>
	<th>Suppier Name</th>
	<th>Purchase Total</th>
	<th>Remarks</th>
	<th>Prepared By</th>
	<th>Delete</th>
	</thead>
	<tbody valign="top">';

	$result=mysqli_query($conn, "SELECT * FROM purchase_order WHERE cancel_status='0' ORDER BY id DESC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
			<td><a href="purchase_order.php?job=edit&id='.$row[id].'"  ><img src="images/edit.png" alt="Edit" /></a></td>

			<td><a href="purchase_order.php?job=print_preview&id='.$row[id].'"  ><img src="images/print.png" alt="Print" width="24" height="24" /></a></td>
			
			<td>'.$row[purchase_order_no].'</td>
					
			<td>'.$row[date].'</td>
					
			<td>'.$row[supplier_name].'</td>
			
			<td>'.$row[total].'</td>
		
			<td>'.$row[remarks].'</td>
			
			<td>'.strtoupper($row[prepared_by]).'</td>
		
			<td><a href="#" onclick="javascript:showConfirm(\'Are you sure you want to delete this entry?\',\'\',\'Yes\',\'purchase_order.php?job=delete&id='.$row[id].'\',\'No\',\'purchase_order.php?job=search\')"><img src="images/close.png" alt="Delete" /></a></td>
		</tr>';
	}
	echo '</tbody></table>';
	
	include 'conf/closedb.php';
}

function get_purchase_order_info($id){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM purchase_order WHERE id='$id'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	include 'conf/closedb.php';
}

function get_purchase_order_info_by_purchase_no($purchase_order_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM purchase_order WHERE purchase_order_no='$purchase_order_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	include 'conf/closedb.php';
}

function  update_purchase_order($id, $purchase_order_no, $supplier_name, $prepared_by, $total, $updated_by){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$date = date("Y-m-d");

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE purchase_order SET
	purchase_order_no='$purchase_order_no',
	date='$date',
	supplier_name='$supplier_name',
	prepared_by='$prepared_by',
	total='$total',
	due='$total',
	updated_by='$updated_by' 
	WHERE id='$id'";

	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function  calncel_items_for_purchase_order_no($purchase_order_no){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE purchase_order_has_items SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]',
	saved='1'
	WHERE purchase_order_no='$purchase_order_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function cancel_purchase_order($id){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE purchase_order SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]'
	WHERE id='$id'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function get_purchase_order_item_id($purchase_order_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT MAX(id) FROM purchase_order_has_items WHERE  cancel_status='0' ");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row['MAX(id)'];
	}
	
	include 'conf/closedb.php';
}


