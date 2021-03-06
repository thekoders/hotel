<?php
function list_employees(){
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<table class="employee_home_table">
			<thead valign="top">
				<th>Edit</th>
				<th>Full Name</th>
				<th>Mobile No</th>
				<th>User Name</th>
				<th>Permissions</th>
				<th>Delete</th>
			</thead>
			<tbody valign="top">';

	$result=mysqli_query($conn, "SELECT * FROM employees WHERE cancel_status='0' ORDER BY id DESC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
			<td><a href="employees.php?job=edit&id='.$row[id].'"  ><img src="images/edit.png" alt="Edit" /></a></td>
				
			<td>'.$row[full_name].'</td>
					
			<td>'.$row[mobile].'</td>
			
			
			';
		if($row[user]==1){
			echo '
			<td>'.strtolower($row[employee_name]).'</td>
			
			<td align="center"><a href="employees.php?job=access&id='.$row[id].'"  ><img src="images/lock.png" alt="Edit" width="24" height="24"/></a></td>';
		}
		else{
			echo'<td></td><td></td>';
		}
		echo'
			<td align="center"><a href="#" onclick="javascript:showConfirm(\'Are you sure you want to delete this entry?\',\'\',\'Yes\',\'employees.php?job=delete&id='.$row[id].'\',\'No\',\'employees.php\')"><img src="images/close.png" alt="Delete" /></a></td>
		</tr>';
	}
	echo '</tbody></table>';

	include 'conf/closedb.php';
}

/*function list_users(){
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<table class="employee_home_table">
	<thead valign="top">
	<th>Full Name</th>
	<th>User Name</th>
	<th>Permissions</th>
	</thead>
	<tbody valign="top">';

	$result=mysqli_query($conn, "SELECT * FROM employees WHERE user='1' AND cancel_status='0' ORDER BY id DESC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
			<td>'.$row[full_name].'</td>
					
			<td>'.strtolower($row[employee_name]).'</td>
			
			<td align="center"><a href="employees.php?job=access&id='.$row[id].'"  ><img src="images/lock.png" alt="Edit" width="24" height="24"/></a></td>
		</tr>';
	}
	echo '</tbody></table>';

	include 'conf/closedb.php';
}
*/
function list_employees_search($search){
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<table class="employee_home_table">
			<thead valign="top">
			<th>Edit</th>
			<th>Employee Name</th>
			<th>Full Name</th>
			<th>Email</th>
			<th>Telephone No</th>
			<th>Mobile No</th>
			<th>Delete</th>
			</thead>
			<tbody valign="top">';

	$result=mysqli_query($conn, "SELECT * FROM employees WHERE employee_name LIKE '%$search%' ORDER BY id DESC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
			<td><a href="employees.php?job=edit&id='.$row[id].'"  ><img src="images/edit.png" alt="Edit" /></a></td>

			<td>'.$row[employee_name].'</td>
			
			<td>'.$row[full_name].'</td>
			
			<td>'.$row[email].'</td>
			
			<td>'.$row[telephone].'</td>
					
			<td>'.$row[mobile].'</td>
		
			<td align="center"><a href="#" onclick="javascript:showConfirm(\'Are you sure you want to delete this entry?\',\'\',\'Yes\',\'employees.php?job=delete&id='.$row[id].'\',\'No\',\'employees.php?job=search\')"><img src="images/close.png" alt="Delete" /></a></td>
		</tr>';
	}
	echo '</tbody></table>';

	include 'conf/closedb.php';
}

function save_employees($employee_name, $full_name, $department, $email, $telephone, $mobile, $address, $user, $user_name, $password){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$passwordmd5=md5($password);

	 
	$query = "INSERT INTO employees (id, employee_name, full_name, department, email, telephone, mobile, address, user, user_name, password, code)
	VALUES ('', '$employee_name', '$full_name', '$department', '$email', '$telephone', '$mobile', '$address', '$user', '$user_name', '$passwordmd5', '$password')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}

function get_employee_info($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM employees WHERE id='$id'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	include 'conf/closedb.php';
}

function update_employees($id, $employee_name, $full_name, $department, $email, $telephone, $mobile, $address, $user, $user_name, $password){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$passwordmd5=md5($password);

	 
	$query = "UPDATE employees SET
	employee_name='$employee_name',
	full_name='$full_name',
	department='$department',
	email='$email',
	telephone='$telephone',
	mobile='$mobile',
	address='$address',
	user='$user',
	user_name='$user_name', 
	password='$passwordmd5', 
	code='$password'
	WHERE id='$id'";

	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function cancel_employee($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	 
	$query = "UPDATE employees SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]'
	WHERE id='$id'";
	mysqli_query($conn, $query);


	include 'conf/closedb.php';
}

