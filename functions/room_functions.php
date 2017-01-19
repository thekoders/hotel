<?php
function save_room($room_no,$room_cat) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ( $conn, $dbname );
	$query = "INSERT INTO room (id, room_no,room_cat)
	VALUES ('', '$room_no','$room_cat')";
	
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function list_rooms() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="box-body">
			<table  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
                  <thead>
                       <tr>
                           <th>Edit</th>
						   <th>Room No</th>
						   <th>Room Category</th>
						   <th>view</th>
                           <th>Delete</th>
                       </tr>
                  </thead>
                  <tbody valign="top">';
	$i = 1;
	$result = mysqli_query ( $conn, "SELECT * FROM room" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		echo '<td><a href="room.php?job=edit&id=' . $row [id] . '"  ><i class="fa fa-edit fa-2x"></i></a></td>
					
		<td>' . $row [room_no] . '</td>	
		<td>' . $row [room_cat] . '</td>	
		<td><a > <i class="fa fa-eye"></i></td>			
					
		<td><a href="room.php?job=delete&id=' . $row [id] . '" onclick="javascript:return confirm(\'Are you sure you want to delete this entry?\')"><i class="fa fa-times fa-2x"></i></a></td>
	
		</tr>';
		
		$i ++;
	}
	
	echo '</tbody>
          </table>
          </div>';
	
	
}
function get_room_info($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM room WHERE id='$id'" );
	
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) 

	{
		return $row;
	}
	
	
}

function get_room_info_by_room_no($room_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result = mysqli_query ($conn, "SELECT * FROM room WHERE room_no='$room_no'" );

	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) )

	{
		return $row;
	}


}

function update_rooms($id, $room_number,$room_cat) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE room SET
	room_no='$room_number',
	room_cat='$room_cat'
	WHERE id='$id'";
	
	mysqli_query ($conn, $query );
	
	
}



function cancel_rooms($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE rooms SET
	cancel_status='1'
	WHERE id='$id'";
	
	mysqli_query ($conn, $query );
	
	
}

function list_room_type() {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result = mysqli_query ( $conn, "SELECT * FROM room_cat" );
	$i = 0;
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$room_types [$i] = $row ['category'];

		$i ++;
	}

	return $room_types;

}

function list_room_number_by_type($room_cat) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result = mysqli_query ( $conn, "SELECT * FROM room WHERE room_cat='$room_cat'" );
	$i = 0;
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		$room_no [$i] = $row ['room_no'];

		$i ++;
	}

	return $room_no;
	
}


function list_rooms_in_home(){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM room" );
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$date=date('Y-m-d');
		$room_status_info=get_room_has_status_info($row['room_no'], $date);
		if($room_status_info[status_id]){
			$status_info=get_status_info($room_status_info[status_id]);
			$color=$status_info['color'];
		}
		else{
			$color="green";
		}
		echo '
				<div class="col-lg-4 col-xs-6">
					<div class="info-box">
				
						<a href="room_info.php?job=room_info&room_no=' . $row [room_no] . '"  >
			            	<span class="info-box-icon bg-'.$color.'">'.$row['room_no'].'</span>
						</a>
			            			
			            <div class="info-box-content">';
						
						$result1=mysqli_query($conn, "SELECT * FROM room_has_facility WHERE room_no='$row[room_no]' " );
						while($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC))
						{
							$info=get_facility_info($row1[facility_id]);
						    echo'<i class="fa fa-square text-'.$info[color].'" style="float: left; margin-left: 1px;"></i>';
						}            		
              				echo' <br> <span class="info-box-text" style="line-height: 15px;">Type <br /><strong>'.$row['room_cat'].'</strong></span>
              		
            			</div>
            		</div>
              	</div>';
	}

}

function list_available_rooms_in_home(){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM room" );
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$date=date('Y-m-d');
		$room_status_info=get_room_has_status_info($row['room_no'], $date);
		if($room_status_info[status_id]){
			$status_info=get_status_info($room_status_info[status_id]);
			$color=$status_info['color'];
		}
		else{
			$color="green";
			echo '
				<div class="col-lg-4 col-xs-6">
					<div class="info-box">
			
						<a href="room_info.php?job=room_info&room_no=' . $row [room_no] . '"  >
			            	<span class="info-box-icon bg-'.$color.'">'.$row['room_no'].'</span>
						</a>
			
			            <div class="info-box-content">';

			$result1=mysqli_query($conn, "SELECT * FROM room_has_facility WHERE room_no='$row[room_no]' " );
			while($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC))
			{
				$info=get_facility_info($row1[facility_id]);
				echo'<i class="fa fa-square text-'.$info[color].'" style="float: left; margin-left: 1px;"></i>';
			}
			echo' <br> <span class="info-box-text" style="line-height: 15px;">Type <br /><strong>'.$row['room_cat'].'</strong></span>
			
            			</div>
            		</div>
              	</div>';
			
		}

	}

}

function get_room_has_status_info($room_no, $date) {
	include 'conf/main_config.php';
	include 'conf/opendb.php';

	$result = mysqli_query ($conn, "SELECT * FROM room_has_status WHERE room_no='$room_no' AND date='$date'" );

	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) )

	{
		return $row;
	}


}


function get_status_info($status_id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result = mysqli_query ($conn, "SELECT * FROM room_status WHERE id='$status_id'" );

	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) )

	{
		return $row;
	}


}

function list_facility_in_room(){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM facility " );
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{

		echo '
                  <div class="checkbox">
                    <label>
                    <input type="checkbox" name="facility[]" value="'.$row['id'].'">
                    '.$row['facility'].'
                    </label>
                 </div>  
			';
	}

}

function get_room_id(){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT MAX(id) AS id FROM room");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$max_id=$row['id']+1;
		$max_id = str_pad($max_id, 5, "0", STR_PAD_LEFT);
		$room_id="RM-".$max_id;
		return $room_id;
	}
}

function add_facility($room_id, $room_no, $facility_id, $facility){
	include 'conf/config.php';
	include 'conf/opendb.php';

	
	$query = "INSERT INTO room_has_facility(room_id, facility, facility_id, room_no)
	VALUES ('$room_id', '$facility', '$facility_id', '$room_no')";
	mysqli_query($conn, $query) or die(mysqli_error($conn));

	include 'conf/closedb.php';
}

function list_room_full_detail($id){
	include 'conf/config.php';
	include 'conf/opendb.php';


	$result=mysqli_query($conn, "SELECT * FROM room WHERE id='$id'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		//$room_info=get_caller_info_by_contact_number($row[telephone_num]);

		echo'

	<div class="col-xs-8">

          <div class="table-responsive">
            <table class="table" style="font-size:20px;">
              <tr>
                <th style="width:50%">Room Number:</th>
                <td>'.$row[room_no].'</td>
              </tr>
              <tr>
                <th>Asked Date </th>
                <td>'.$row[asked_date].'</td>
              </tr>
              <tr>
                <th>Remarks:</th>
                <td>'.$row[remarks].'</td>
              </tr>
              <tr>
                <th style="width:50%">Name :</th>
                <td>'.$caller_info[caller_name].'</td>
              </tr>
              <tr>
                <th>Address </th>
                <td>'.$caller_info[address].'</td>
              </tr>
              <tr>
                <th>District:</th>
                <td>'.$caller_info[district].'</td>
              </tr>
              <tr>
                <th style="width:50%">Country :</th>
                <td>'.$caller_info[country].'</td>
              </tr>
              <tr>
                <th>Email  </th>
                <td>'.$caller_info[email].'</td>
              </tr>
              <tr>
                <th>Referel:</th>
                <td>'.$caller_info[referel].'</td>
              </tr>
              <tr>
                <th style="width:50%"> Date Of Birth:</th>
                <td>'.$caller_info[dob].'</td>
              </tr>
              <tr>
                <th>NIC  </th>
                <td>'.$caller_info[nic].'</td>
              </tr>
              <tr>
                <th>Passport:</th>
                <td>'.$caller_info[passport].'</td>
              </tr>

            </table>
    </div>

		';

	}

	include 'conf/closedb.php';
}


