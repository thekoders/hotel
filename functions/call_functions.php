<?php
function save_call( $telephone_num, $asked_date, $remarks, $room_cat) {
    include 'conf/config.php';
    include 'conf/opendb.php';

    mysqli_select_db ( $conn, $dbname );

    $query = "INSERT INTO calls (id, telephone_num, asked_date, remarks, room_cat)
	VALUES ('', '$telephone_num','$asked_date', '$remarks','$room_cat')";

    mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );


}

function save_caller( $caller_name, $address, $district, $country, $telephone_num, $email, $referel, $dob,$nic, $passport ) {

    include 'conf/config.php';
    include 'conf/opendb.php';

    mysqli_select_db ( $conn, $dbname );

    $query = "INSERT INTO caller (id, caller_name, address, district, country, phone, email, referel, dob , nic, passport)
	VALUES ('', '$caller_name', '$address', '$district', '$country', '$telephone_num','$email', '$referel', '$dob' ,'$nic', '$passport')";

    mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );

}


function list_call() {
    include 'conf/config.php';
    include 'conf/opendb.php';

    echo '<div class="box-body">
			<table  id="example2" style="width: 100%;" class="table table-bordered table-striped">
                  <thead>
                       <tr>
                           <th>Telephone Number</th>
						   <th>Asked Date</th>
						   <th>Remarks</th>
						   <th>view</th>
						   <th></th>
                       </tr>
                  </thead>
                  <tbody valign="top">';

    $result = mysqli_query ( $conn, "SELECT * FROM calls" );
    while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {

        echo '	
		<td>' . $row [telephone_num] . '</td>	
		<td>' . $row [asked_date] . '</td>
		<td>' . $row [remarks] . '</td>	
		<td><a href="call.php?job=view_caller_detail&id='.$row[id].'"> <i class="fa fa-eye"></i></a></td>
		<td><a href="booking.php?job=booking_form&telephone_num='.$row[telephone_num].'&booking_status_by=Call"> <button type="button" class="btn btn-block btn-success">Proceed to book</button></a></td>									
		</tr>';

        $i ++;
    }

    echo '</tbody>
          </table>
          </div>';


}

function list_call_full_detail($id){
    include 'conf/config.php';
    include 'conf/opendb.php';


    $result=mysqli_query($conn, "SELECT * FROM calls WHERE id='$id'");
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $caller_info=get_caller_info_by_contact_number($row[telephone_num]);

        echo'

	<div class="col-xs-8">

          <div class="table-responsive">
            <table class="table" style="font-size:20px;">
              <tr>
                <th style="width:50%">Telephone Number:</th>
                <td>'.$row[telephone_num].'</td>
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

function get_caller_info_by_contact_number($telephone_num){
    include 'conf/config.php';
    include 'conf/opendb.php';

    $result=mysqli_query($conn, "SELECT * FROM caller WHERE phone='$telephone_num'");
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        return $row;
    }
}

function get_guest_info_by_contact_number($telephone_num){
    include 'conf/config.php';
    include 'conf/opendb.php';

    $result=mysqli_query($conn, "SELECT * FROM guest WHERE phone='$telephone_num'");
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        return $row;
    }
}

function get_caller_info_by_caller_id($caller_id){
    include 'conf/config.php';
    include 'conf/opendb.php';

    $result=mysqli_query($conn, "SELECT * FROM caller WHERE id='$caller_id'");
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        return $row;
    }
}


function get_room_info_by_contact_number($telephone_num){
    include 'conf/config.php';
    include 'conf/opendb.php';

    $result=mysqli_query($conn, "SELECT * FROM calls WHERE telephone_num='$telephone_num'");
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        return $row;
    }
}

function list_room_types() {
    include 'conf/config.php';
    include 'conf/opendb.php';

    $result = mysqli_query ( $conn, "SELECT * FROM room_cat" );
    $i = 0;
    while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
        $room_names [$i] = $row ['category'];

        $i ++;
    }

    return $room_names;

}

