<?php include("data_connection.php");

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};


// Check for success message in the session
if (isset($_SESSION['success_message'])) {
   echo '<div class="message"><span>' . $_SESSION['success_message'] . '</span> <i class="alert-message" onclick="this.parentElement.style.display = `none`;">
	  <img src="image/cross.png" alt="" class="cross-icon"></i> </div>';
    // Clear the success message from the session to show it only once
    unset($_SESSION['success_message']);
}

if (isset($_POST['edit-visitor'])) {
    $update_id = $_POST['update_id'];
	$update_type = $_POST['update_type'];
    $update_name = $_POST['update_name'];
    $update_email = $_POST['update_email'];
    $update_number = $_POST['update_number'];
    $update_date = $_POST['update_date'];
	$visit_purpose = $_POST['visit_purpose'];
    $resident_name = $_POST['resident_name'];
    $resident_unit = $_POST['resident_unit'];
	
    $update_query = mysqli_query($connect, "UPDATE `visitor` SET
		visitor_type = '$update_type',
        visitor_name = '$update_name', 
        visitor_email = '$update_email', 
        visitor_number = '$update_number', 
        visit_date = '$update_date',
		visit_purpose = '$visit_purpose',
		resident_name = '$resident_name',
		resident_unit = '$resident_unit'
        WHERE visitor_id = '$update_id'");

    if ($update_query) {
		$_SESSION['success_message'] = 'Visitor Registration Updated Successfully!';
    } else {
        $message[] = 'Error updating visitor registration: ' . mysqli_error($connect);
    }

    header("Location: ManageVisitorRegistration.php");
}

if (isset($_GET['delete-visitor'])) {
    $delete_id = $_GET['delete-visitor'];

    $delete_query = mysqli_query($connect, "DELETE FROM `visitor` WHERE visitor_id = $delete_id");

    if ($delete_query) {
		$_SESSION['success_message'] = 'Visitor Registration Deleted Successfully!';
    } else {
        $message[] = 'Error deleting visitor registration: ' . mysqli_error($connect);
    }

    header("Location: ManageVisitorRegistration.php");
}


if (isset($_POST['update-visitor-status'])) {
    $visitor_id = $_POST['id'];
    $visitor_status = $_POST['update-visitor-status'];

    $update_status = mysqli_query($connect, "UPDATE `visitor` SET approval_status = '$visitor_status' WHERE visitor_id = '$visitor_id'");

    $message[] = 'Visitor Registration Status Has Updated!';
}
?>

<!DOCTYPE html>
<html lang="en">
 <head>
    <title>Manage Visitor Registration</title>

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


/* Filter Buttons */
.filter-buttons button {
  background-color: #666666;
  border: none;
  color: #fff;
  padding: 10px 20px;
  margin: 5px;
  cursor: pointer;
  font-size: 18px;
  border-radius: 5px;
}

.filter-buttons button:hover {
  background-color: #999999;
}

.filter_container{
	padding:15px 0 15px 0;;
}

.addVisitor-btn{
	color:white;
	font-size: 16px;
    border: 1px solid #C27BA0; 
    padding: 8px 12px; 
    border-radius: 4px; 
    text-decoration: none; 
	background-color:#C27BA0;
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
                    <h2>Manage <b>Visitor Registration</b><a href="register_visitor.php" class="addVisitor-btn"><i class="ri-notification-badge-fill"></i></i> Add Visitor</a></h2>
                </div>
				  <!-- Filter Buttons -->
<div class="filter_container">
  <div class="filter-buttons">
    <button onclick="resetFilter()">All</button>
    <button onclick="filterScheduled()">Scheduled</button>
    <button onclick="filterRegistered()">Registered</button>
  </div>
</div>

                <table class="table">
                    <thead>
                        <tr>
						    <th>Type</th>
                            <th>Visitor Name</th>
                            <th>Visitor Email</th>
                            <th>Visitor Number</th>
                            <th>Visit Date</th>
                            <th>Visit Purpose</th>
                            <th>Resident Name</th>
                            <th>Resident Unit</th>
                            <th>Approval Status</th>
                        </tr>
                    </thead>
 				<?php
					$results = mysqli_query($connect, "SELECT * FROM `visitor`");
					if(mysqli_num_rows($results) > 0){
					while($row = mysqli_fetch_assoc($results)){
				?>
					<tr>
						<td><?php echo $row['visitor_type']; ?></td>
						<td><?php echo $row['visitor_name']; ?></td>
						<td><?php echo $row['visitor_email']; ?></td>
						<td><?php echo $row['visitor_number']; ?></td>
						<td><?php echo $row['visit_date']; ?></td>
						<td><?php echo $row['visit_purpose']; ?></td>
						<td><?php echo $row['resident_name']; ?></td>
						<td><?php echo $row['resident_unit']; ?></td>
						<form action="" method="POST">
						<input type="hidden" name="id" value="<?= $row['visitor_id']; ?>">
						<td class="status">
						<select name="update-visitor-status" class="drop-down">
							<option value="" selected disabled><?php echo $row['approval_status']; ?></option>
							<option value="Pending">Pending</option>
							<option value="Approved">Approved</option>
							<option value="Declined">Declined</option>
						</select></td>
						<div class="flex-btn">
							<td><i class="ri-delete-bin-fill"></i><a href="ManageVisitorRegistration.php?delete-visitor=<?= $row['visitor_id']; ?>" class="Deletebtn" onclick="return confirm('Are You Sure You Want To Delete This Visitor Account?');">Delete</a></td>
							<td><button type="submit" style="cursor: pointer;" class="Updatebtn" name="update-visitor"><i class="ri-edit-box-fill"></i> Update</button></td>
							<td><a href="ManageVisitorRegistration.php?edit=<?= $row['visitor_id']; ?>" name="edit-visitor" class="Addbtn"><i class="ri-edit-2-fill"></i>Edit</a></td>
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

<script>
  // Function to filter by Registered
  function filterRegistered() {
    filterByType("Registered");
  }

  // Function to filter by Scheduled
  function filterScheduled() {
    filterByType("Scheduled");
  }

  // Function to reset the filter
  function resetFilter() {
    showAll();
  }

  // Function to filter by visitor type
function filterByType(type) {
  const rows = document.querySelectorAll('.table tbody tr');

  rows.forEach(row => {
    const visitorType = row.querySelector('td:nth-child(1)').innerText; // Assuming the type is in the first column

    if (visitorType === type || type === "All") {
      row.style.display = 'table-row';
    } else {
      row.style.display = 'none';
    }
  });
}


  // Function to show all rows
function resetFilter() {
  const rows = document.querySelectorAll('.table tbody tr');
  rows.forEach(row => {
    row.style.display = 'table-row';
  });
}

</script>
	
<!-- Update Visitor -->
	<div class="edit-container">
	<?php
   if(isset($_GET['edit'])){
      $update_acc = $_GET['edit'];
      $update_query = mysqli_query($connect, "SELECT * FROM `visitor` WHERE visitor_id = $update_acc");
      if($update_query)
	  {
         while($row_update= mysqli_fetch_assoc($update_query))
		 {
   ?>
   
   <form action="" method="post">
    <p style="font-size:40px; font-weight:bold; font-family:Comic Sans Mc; text-align:left;"> Edit Resident </p>
	<hr style="margin-bottom:10px; color:black;"/>
	<input type="hidden" name="update_id" value="<?php echo $row_update['visitor_id']; ?>">
        <span class="left-align">Type :</span>
        <select name="update_type"class="row"  style="text-align: left;" required>
        <option value="Registered" <?php echo ($row_update['visitor_type'] == 'Registered') ? 'selected' : ''; ?>>Registered</option>
        <option value="Scheduled" <?php echo ($row_update['visitor_type'] == 'Scheduled') ? 'selected' : ''; ?>>Scheduled</option>
        </select>
	  <span class="left-align">Name :</span><input type="text" class="row"  name="update_name" value="<?php echo $row_update['visitor_name']; ?>"required> 
	  <span class="left-align">Email Address :</span><input type="email"  name="update_email" class="row" value="<?php echo $row_update['visitor_email']; ?>"required>
	  <span class="left-align">Phone Number :</span><input type="tel"  pattern="[0-9]{3}-[0-9]{7}" name="update_number" class="row" value="<?php echo $row_update['visitor_number']; ?>"required>
		<span class="left-align">Visit Date :</span><input type="date" name="update_date" class="row" value="<?php echo $row_update['visit_date']; ?>"		>
		<span class="left-align">Visit Purpose :</span><input type="text"  name="visit_purpose" class="row" value="<?php echo $row_update['visit_purpose']; ?>"required>
		<span class="left-align">Resident Name :</span><input type="text"  name="resident_name" class="row" value="<?php echo $row_update['resident_name']; ?>"required>
		<span class="left-align">Resident Unit :</span>
		<select  name="resident_unit" class="row" value="<?php echo $row_update['resident_unit']; ?>"required>
					<option value="A-1">A-1</option>
					<option value="A-2">A-2</option>
					<option value="A-3">A-3</option>
					<option value="A-4">A-4</option>
					<option value="A-5">A-5</option>
					<option value="A-6">A-6</option>
		</select>
	  <input type="submit" value="Edit" name="edit-visitor" class="button">
      <input style="width:100%;" type="reset" value="Cancel" id="close-edit" class="option-button">
   </form>
	<?php
            };
         };
         echo '<script src="js/script.js"></script>';
      };
   ?>

    </div>
  </body>
</html>