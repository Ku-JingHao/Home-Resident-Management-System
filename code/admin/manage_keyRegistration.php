<?php include("data_connection.php");

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['add_resident'])){
   $update_id = $_POST['update_id'];
   $update_name = $_POST['update_name'];
   $update_email = $_POST['update_email'];
   $update_number = $_POST['update_number'];
   $update_date = $_POST['update_date'];

   $update_query = mysqli_query($connect, "UPDATE `keyregistration` SET keyRegistration_name = '$update_name', keyRegistration_email = '$update_email', 
   keyRegistration_number = '$update_number', keyRegistration_date = '$update_date' WHERE keyRegistration_id = '$update_id'");
   
  header("Location: manage_keyRegistration.php");
};

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    // Update the specific columns to NULL instead of deleting the entire row
    $update_query = mysqli_query($connect, "UPDATE `keyregistration` SET keyRegistration_name = 'None', keyRegistration_email = 'None', keyRegistration_number = 'None', keyRegistration_date = NULL WHERE keyRegistration_id = $delete_id");
    header("Location: manage_keyRegistration.php");
}

if(isset($_POST['update-status'])){

   $keyRegistration_id = $_POST['keyRegistration-id'];
   $key_status = $_POST['key-status'];
   
   $update_status = mysqli_query($connect, "UPDATE `keyregistration` SET keyRegistration_status = '$key_status' WHERE keyRegistration_id = '$keyRegistration_id'");
   $message[] = 'Key Registration Status Has Updated!';
}
?>

<!DOCTYPE html>
<html lang="en">
 <head>
    <title>Manage Key Registration</title>

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
	width:90px;
	padding-top:5px;
	padding-bottom:5px;
	border: none;
    outline: none;
	background-color: white;
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
    text-decoration: none; 
	color:green;
	border: none;
    outline: none;
}

.Addbtn:hover{
	color:#6AA84F;
}


/* edit */
.edit-container, .message-container {
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

.message-container form {
   max-width: 80rem; 
   width: 100%; 
   border-radius: 0.5rem;
   background-color: white;
   text-align: center;
   padding: 2rem;
   margin: auto;
   overflow-y: auto; /* Add this property to make the container scrollable */
   max-height: 90vh; /* Set a max height if needed */
}

.edit-container form .row, message-container form .row{
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

.drop-down{
	width:90px;
	height:30px;
	font-size:15px;
	font-family: Average;
}

.messageBtn{
	color:black;
	font-size: 16px;
    border: 1px solid yellow; 
    padding: 8px 12px; 
    border-radius: 4px; 
    text-decoration: none; 
	background-color:yellow;
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
      <!-- Sidebar -->
       <?php include 'sidebar.php'; ?>
      <!-- Main -->
      <main class="main-container">
        <div class="container">
	<div class="table-responsive">
		<div class="table-wrapper">
			<div class="table-title">
						<h2>Manage <b>Key Registration</b><a href="view_message.php" class="messageBtn"><i class="ri-notification-badge-fill"></i></i> Messages</a></h2>
			</div>
			<table class="table">
				<thead>
					<tr>
						<th>Unit Number</th>
						<th>Key Type</th>
						<th>Resident Name</th>
						<th>Resident Email</th>
						<th>Resident Number</th>
						<th>Requested Date</th>
						<th>Key Status</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$results = mysqli_query($connect, "SELECT * FROM `keyregistration`");
					if(mysqli_num_rows($results) > 0){
					while($row = mysqli_fetch_assoc($results)){
				?>
					<tr>
						<td><?php echo $row['unit_number']; ?></td>
						<td><?php echo $row['key_type']; ?></td>
						<td><?php echo $row['keyRegistration_name']; ?></td>
						<td><?php echo $row['keyRegistration_email']; ?></td>
						<td><?php echo $row['keyRegistration_number']; ?></td>
						<td><?php echo $row['keyRegistration_date']; ?></td>
						<form action="" method="POST">
						<input type="hidden" name="keyRegistration-id" value="<?= $row['keyRegistration_id']; ?>">
						<td class="status">
						<select name="key-status" class="drop-down">
							<option value="" selected disabled><?= $row['keyRegistration_status']; ?></option>
							<option value="Activate">Activate</option>
							<option value="Deactivate">Deactivate</option>
						</select></td>
						<div class="flex-btn">
							<td><i class="ri-delete-bin-fill"></i><a href="manage_keyRegistration.php?delete=<?= $row['keyRegistration_id']; ?>"  class="Deletebtn" onclick="return confirm('Are You Sure You Want To Delete This Resident Account?');">Delete</a></td>
							<td><button type="submit" style="cursor: pointer;" class="Updatebtn" name="update-status"><i class="ri-edit-box-fill"></i> Update</button></td>
							<td><a href="manage_keyRegistration.php?add=<?= $row['keyRegistration_id']; ?>" class="Addbtn"><i class="ri-user-add-fill"></i>Add</a></td>
						</div>
						</form>
					</tr>
				<?php
				};
					}
				else
				{
					echo '<p class="empty">None</p>';
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
   if(isset($_GET['add'])){
      $update_acc = $_GET['add'];
      $update_query = mysqli_query($connect, "SELECT * FROM `keyregistration` WHERE keyRegistration_id = $update_acc");
      if($update_query)
	  {
         while($row_update= mysqli_fetch_assoc($update_query))
		 {
   ?>
   <form action="" method="post">
    <p style="font-size:40px; font-weight:bold; font-family:Comic Sans Mc; text-align:left;"> Add Resident </p>
	<hr style="margin-bottom:10px; color:black;"/>
	<input type="hidden" name="update_id" value="<?php echo $row_update['keyRegistration_id']; ?>">
      <span class="left-align">Name :</span><input type="text" class="row" name="update_name" value="<?php echo $row_update['keyRegistration_name']; ?>"> 
	  <span class="left-align">Email Address :</span><input type="email" class="row"  name="update_email" value="<?php echo $row_update['keyRegistration_name']; ?>"> 
	  <span class="left-align">Phone Number :</span><input type="tel"  name="update_number" class="row" value="<?php echo $row_update['keyRegistration_number']; ?>">
		<span class="left-align">Date Registered :</span><input type="date" name="update_date" max="2024-12-12" placeholder="dd/mm/yyyy" class="row" value="<?php echo $row_update['keyRegistration_date']; ?>" required>
	  <input type="submit" value="Add" name="add_resident" class="button">
      <input style="width:100%;" type="reset" value="Cancel" id="close-edit" class="option-button">
   </form>
	<?php
            };
         };
         echo "<script>
				document.addEventListener('DOMContentLoaded', function() {
    // Get all elements with the class 'Addbtn'
    var addBtns = document.querySelectorAll('.Addbtn');

    // Get the edit container element
    var editContainer = document.querySelector('.edit-container');

    // Add a click event listener to each 'Addbtn'
    addBtns.forEach(function(addBtn) {
        addBtn.addEventListener('click', function(event) {
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
