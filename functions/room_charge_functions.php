<?php
function save_room_type_has_charges($category, $season_type,$meal_type,$price) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ( $conn, $dbname );
	$query = "INSERT INTO room_type_has_charges (id, category,season_type, meal_type, price)
	VALUES ('', '$category', '$season_type', '$meal_type', $price)";
	
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}

function update_room_type_has_charges( $id, $category, $season_type,$meal_type,$price) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE room_type_has_charges SET
	category='$category',
	season_type='$season_type',
	meal_type='$meal_type',
	price='$price'
	WHERE id='$id'";
	
	mysqli_query ($conn, $query );
	
	
}

function list_room_type_has_charges() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="box-body">
			<table  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
                  <thead>
                       <tr>
                           <th>Edit</th>
                           <th>Room Category</th>
                           <th>Season</th>
						   <th>Meal</th>
						   <th>Price</th>
                           <th>Delete</th>
                       </tr>
                  </thead>
                  <tbody valign="top">';
	$i = 1;
	$result = mysqli_query ( $conn, "SELECT * FROM room_type_has_charges" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		echo '<td><a href="room_charge.php?job=edit&id=' . $row [id] . '"  ><i class="fa fa-edit fa-2x"></i></a></td>

		<td>' . $row [category] . '</td>
		<td>' . $row [season_type] . '</td>
		<td>' . $row [meal_type] . '</td>
		<td>' . $row [price] . '</td>
		
		<td><a href="room_charge.php?job=delete&id=' . $row [id] . '" onclick="javascript:return confirm(\'Are you sure you want to delete this entry?\')"><i class="fa fa-times fa-2x"></i></a></td>
	
		</tr>';
		
		$i ++;
	}
	
	echo '</tbody>
          </table>
          </div>';
	
	
}

function get_room_charge_info_by_id($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM room_type_has_charges WHERE id='$id'" );
	
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) 

	{
		return $row;
	}
	
}

function delete_room_type_has_charges($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "DELETE FROM room_type_has_charges
	WHERE id='$id'";
	
	mysqli_query ($conn, $query );
	
	
}

function select_room_cat(){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result=mysqli_query($conn, "SELECT * FROM room_cat");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
    echo'   <option value="'.$row[category].'">'.$row[category].'</option>';
    }
    include 'conf/closedb.php';
    
}

