<?php include("data_connection.php");

session_start();

if(isset($_SESSION['admin_id'])){
   $admin_id = $_SESSION['admin_id'];
}else{
   $admin_id = '';
};

if (isset($_SESSION['success_message'])) {
    $success_messages = is_array($_SESSION['success_message']) ? $_SESSION['success_message'] : [$_SESSION['success_message']]; // Check if it's an array, otherwise convert it to an array

    foreach ($success_messages as $success_message) {
        echo '<div class="message success"><span>' . $success_message . '</span> <i class="alert-message" onclick="this.parentElement.style.display = `none`;">
            <img src="image/cross.png" alt="" class="cross-icon"></i> </div>';
    }
    unset($_SESSION['success_message']); // Clear the success message from the session to show it only once
}

if(isset($_POST['update_resident'])){
   $update_id = $_POST['update_id'];
   $update_name = $_POST['update_name'];
   $update_email = $_POST['update_email'];
   $update_number = $_POST['update_number'];
   $update_gender = $_POST['gendertype'];
   $update_address = $_POST['update_address'];
   $update_pass = sha1($_POST['update_pass']);

$update_messages = array(); // Initialize an empty array to hold the messages
 
if (!empty($update_name)) { // Update Name
    $update_names = mysqli_query($connect, "UPDATE `resident` SET resident_name = '$update_name' WHERE resident_id = '$update_id'");
    if ($update_names) {
        $update_messages[] = 'Name Updated Successfully!';
    }
}
if (!empty($update_email)) { // Update Email
	$select_email = mysqli_query($connect, "SELECT * FROM `resident` WHERE resident_email = '$update_email'");
	  if(mysqli_num_rows($select_email) > 0){
         $update_messages[] = 'Email Already Taken!';
      }
	  
	  else{
			$update_emails = mysqli_query($connect, "UPDATE `resident` SET resident_email = '$update_email' WHERE resident_id = '$update_id'");
			if ($update_emails) {
			$update_messages[] = 'Email Updated Successfully!';
			}
      }
}
if (!empty($update_number)) { // Update Phone Number
		$select_number = mysqli_query($connect, "SELECT * FROM `resident` WHERE resident_number = '$update_number'");
       if(mysqli_num_rows($select_number) > 0){
         $update_messages[] = 'Number Already Taken!';
      }
	  else{
        $update_numbers =  mysqli_query($connect, "UPDATE `resident` SET resident_number = '$update_number' WHERE resident_id = '$update_id'");
		if ($update_numbers) {
			$update_messages[] = 'Phone Number Updated Successfully!';
		}
      }
}
if (!empty($update_gender)) { // Update Gender
    $update_gender = mysqli_query($connect, "UPDATE `resident` SET resident_gender = '$update_gender' WHERE resident_id = '$update_id'");
    if ($update_gender) {
        $update_messages[] = 'Gender Updated Successfully!';
    }
}
if (!empty($update_address)) { // Update Unit Number
    $update_address = mysqli_query($connect, "UPDATE `resident` SET resident_unit = '$update_address' WHERE resident_id = '$update_id'");
    if ($update_address) {
        $update_messages[] = 'Unit Number Updated Successfully!';
    }
}
if (!empty($update_pass)) { // Update Password
    $update_pass = mysqli_query($connect, "UPDATE `resident` SET resident_password = '$update_pass' WHERE resident_id = '$update_id'");
    if ($update_pass) {
        $update_messages[] = 'Password Updated Successfully!';
    }
}

$_SESSION['success_message'] = $update_messages; // Set the session message as an array of update messages
header("Location: manage_resident.php"); 
};

if(isset($_GET['delete']))
{
   $delete_id = $_GET['delete'];
   $delete_users = mysqli_query($connect, "DELETE FROM `resident` WHERE resident_id = $delete_id");
   
    if ($delete_users) {
		$_SESSION['success_message'] = 'Resident Account Deleted Successfully!';
    }
	
	header("Location: manage_resident.php");
}
?>

<!DOCTYPE html>
<html>
 <head>
    <title>Manage Residents</title>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">
	<link rel="stylesheet" href="css/styles.css" />
<style>
<?php include'css/styles.css';?>
body {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  color: rgb(70, 71, 81);
  font-family: 'Open Sans', sans-serif;
  background: url(image/admin_bg.jpg);
}

.grid-container {
  display: grid;
  grid-template-columns: 260px 1fr 1fr 1fr;
  grid-template-rows: 0.2fr 3fr;
  grid-template-areas:
    'sidebar header header header'
    'sidebar main main main';
  height: 100vh;
}


/* main */
h2{
	text-align: left;
}
.container{
	padding-top: 40px;
	padding-right:80px;
	padding-left: 80px;
}

.table{
	width:100%;
	text-align:center;
}

thead{
	font-family:Comic Sans MS;
	font-size:16px;
}

tbody{
	font-family:Average;
	font-size:16px;
}

table.table tr td:last-child {
	padding-left: 10px;
}

th:nth-child(4),
td:nth-child(4) {
    width: 150px; /* Adjust the width according to your preference */
}

.table-responsive {
    margin: 30px 0;
}
.table-wrapper {
	background: #fff;
	padding: 20px 25px;
	border-radius: 3px;
	min-width: 1100px;
	box-shadow: 0 1px 1px rgba(0,0,0,.05);
}
.table-title {
		
	font-family:Average;    
	padding-bottom: 15px;
	background:	#073763;
	color: #fff;
	padding: 12px 30px;
	min-width: 100%;
	margin: -20px -25px 10px;
	border-radius: 3px 3px 0 0;
}

.table-title h2 {
	margin: 5px 0 0;
	font-size: 30px;
}

.table-title a {
	float:right;
}


table.table tr th, table.table tr td {
	border-color: #e9e9e9;
	padding: 15px 20px;
	vertical-align: middle;
}


/* update */
.update-container{
   position: fixed;
   top:0; 
   left:0;
   z-index: 1100;
   background-color: transparent;
   padding:2rem;
   display: none;
   align-items: center;
   justify-content: center;
   min-height: 100vh;
   width: 100%;
}

.update-container form{
   width: 40rem;
   border-radius: .5rem;
   background-color: white;
   text-align: center;
   padding:2rem;
}

.update-container form .row{
   width: 270px;
   background-color: white;
   border-radius: .5rem;
   margin:1rem 0;
   font-size: 1.3rem;
   color:black;
   padding:1.2rem 1.4rem;
   text-transform: none;
   font-family:Average;
}


.ri-edit-box-fill, .ri-delete-bin-fill{
	font-size:23px;
}

.ri-delete-bin-fill{
	color:red;
	pointer:cursor;
}

.ri-edit-box-fill{
	color:orange;
	pointer:cursor;
}

.Deletebtn, .Updatebtn{
	font-size:16px;
}

.Deletebtn{
	color:red;
}

.Updatebtn{
	color:orange;
}

.Deletebtn:hover{
	color:#E06666;
}

.Updatebtn:hover{
	color:#F6B26B;
}

.Addbtn{
	color:white;
	font-size: 16px;
    border: 1px solid green; 
    padding: 8px 12px; 
    border-radius: 4px; 
    text-decoration: none; 
	background-color:green;
}

.Addbtn:hover{
	background-color:#6AA84F
}


/* edit */
.edit-container{
   position: fixed;
   top: 0;
   left: 0;
   z-index: 1100;
   background-color: transparent;
   padding: 2rem;
   display: none;
   align-items: center;
   justify-content: center;
   min-height: 100vh;
   width: 100%;
}

.edit-container form{
   max-width: 40rem; 
   width: 100%; 
   border-radius: 0.5rem;
   background-color: white;
   text-align: center;
   padding: 2rem;
   margin: auto;
   overflow-y: auto; /* Add this property to make the container scrollable */
   max-height: 90vh; /* Set a max height if needed */
}

.edit-container form .row{
   width: 100%; 
   max-width: 50rem;
   background-color: white;
   border-radius: 0.5rem;
   margin: 1rem auto; 
   font-size: 18px;
   color: black;
   padding: .8rem 1rem;
   text-transform: none;
   font-family: Average;
   border:1px solid black;
}

.left-align {
    display: block;
    text-align: left;
	font-family: Average;
	color:black;
}

.button,.option-button{
   display: block;
   width: 100%;
   text-align: center;
   background-color: #2E8B57;
   color:white;
   font-size: 1.2rem;
   padding:.8rem 2rem;
   border-radius: 0.5rem;
   cursor: pointer;
   margin-top: 1rem;
   text-decoration: none;
}

.option-button{
	width: 50%;
	background-color:#FF0000;
}

.button:hover{
   background-color: #93C47D;
}

.option-button:hover{
	background-color:#E06666;
}

</style>
 </head>
  <body>
 <?php

if(isset($message))
{
   foreach($message as $message)
   {
	  echo '<div class="message"><span>'.$message.'</span> <i class="alert-message" onclick="this.parentElement.style.display = `none`;">
	  <img src="image/cross.png" alt="" class="cross-icon"></i> </div>';
   };
};

?>

    <div class="grid-container">
     <?php include 'sidebar.php'; ?>
      <!-- Main -->
      <main class="main-container">
        <div class="container">
	<div class="table-responsive">
		<div class="table-wrapper">
			<div class="table-title">
						<h2>Manage <b>Resident</b> <a href="add_resident.php" class="Addbtn"><i class="ri-user-add-fill"></i> Add New Residents</a></h2>
			</div>
			<table class="table">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Email</th>
						<th>Phone Number</th>
						<th>Gender</th>
						<th>Unit Number</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$results = mysqli_query($connect, "SELECT * FROM `resident`");
				if(mysqli_num_rows($results) > 0){
                while($row = mysqli_fetch_assoc($results)){
				?>
					<tr>
						<td><?php echo $row['resident_id']; ?></td>
						<td><?php echo $row['resident_name']; ?></td>
						<td><?php echo $row['resident_email']; ?></td>
						<td><?php echo $row['resident_number']; ?></td>
						<td><?php echo $row['resident_gender']; ?></td>
						<td><?php echo $row['resident_unit']; ?></td>
						
						<form action="" method="POST">
						<input type="hidden" name="resident-id" value="<?= $row['resident_id']; ?>">
						<div class="flex-btn">
							<td><i class="ri-delete-bin-fill"></i><a href="manage_resident.php?delete=<?= $row['resident_id']; ?>" class="Deletebtn" onclick="return confirm('Are You Sure You Want To Delete This Resident Account?');">Delete</a></td>
							<td><i class="ri-edit-box-fill"></i><a href="manage_resident.php?updated=<?php echo $row['resident_id']; ?>" class="Updatebtn">Update</a></td>	
						</div>
						</form>
					</tr>	
				<?php
				};
					}
				else
				{
					echo '<p class="empty">No Resident Account Yet!</p>';
				}
				?>
				</tbody>
			</table>
	</div>        
</div>
</div>
				
      </main>
      <!-- End Main -->
	
	<!-- Update Resident -->
	<div class="edit-container">
	<?php
   if(isset($_GET['updated'])){
      $update_acc = $_GET['updated'];
      $update_query = mysqli_query($connect, "SELECT * FROM `resident` WHERE resident_id = $update_acc");
      if(mysqli_num_rows($update_query) > 0)
	  {
         while($row_update= mysqli_fetch_assoc($update_query))
		 {
   ?>
   
   <form action="" method="post">
    <p style="font-size:40px; font-weight:bold; font-family:Comic Sans Mc; text-align:left;"> Update Resident Account </p>
	<hr style="margin-bottom:10px; color:black;"/>
	  <input type="hidden" name="update_id" value="<?php echo $row_update['resident_id']; ?>">
      <span class="left-align">Name :</span><input type="text" class="row" name="update_name" value="<?php echo $row_update['resident_name'];?>"> 
	  <span class="left-align">Email Address :</span><input type="email" class="row"  name="update_email" value="<?php echo $row_update['resident_email']; ?>"> 
	  <span class="left-align">Phone Number :</span><input type="tel"  name="update_number" class="row" value="<?php echo $row_update['resident_number']; ?>">
     <span class="left-align">Gender:</span>
	<select class="row" name="gendertype">
    <option value="Male">Male</option>
    <option value="Female">Female</option>
	</select>
	  <span class="left-align">Unit Number:</span>
	  <select class="row" name="update_address">
		<option value="" selected disabled><?= $row_update['resident_unit']; ?></option>
		<option value="A-1">A-1</option>
		<option value="A-2">A-2</option>
		<option value="A-3">A-3</option>
		<option value="A-4">A-4</option>
		<option value="A-5">A-5</option>
		<option value="A-6">A-6</option>
	  </select>
      <span class="left-align">Password :<input type="password"  class="row"  name="update_pass" placeholder="***************" class="password" value="<?php echo $row_update['resident_password']; ?>"></p>
	  <input type="submit" value="Update Customer Account" name="update_resident" class="button">
      <input style="width:100%;" type="reset" value="Cancel" id="close-edit" class="option-button">
   </form>
    <?php
            };
         };
         echo "<script>
				document.addEventListener('DOMContentLoaded', function() {
					// Get all elements with the class
					var updateBtns = document.querySelectorAll('.Updatebtn');

					// Get the edit container element
					var editContainer = document.querySelector('.edit-container');

					// Add a click event listener to each Update button
					updateBtns.forEach(function(updateBtn) {
						updateBtn.addEventListener('click', function(event) {
							// Prevent the default link behavior
							event.preventDefault();

							// Toggle the display of the edit container
							editContainer.style.display = 'block';
						});
					});

					// Get the close edit button element
					var closeEditBtn = document.getElementById('close-edit');

					// Add a click event listener to the close edit button
					closeEditBtn.addEventListener('click', function() {
						// Hide the edit container when the close button is clicked
						editContainer.style.display = 'none';
					});
				});
				</script>";
					  };
   ?>
	</div>
    </div>
  </body>
</html>