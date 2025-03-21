<?php include("data_connection.php");

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_GET['deleteMessage']))
{
   $delete_id = $_GET['deleteMessage'];
   $delete_users = mysqli_query($connect, "DELETE FROM `key` WHERE key_id = $delete_id");
   header("Location: manage_keyRegistration.php");  
}

if(isset($_POST['update-status'])){

   $key_id = $_POST['key-id'];
   $key_status = $_POST['key-status'];

   $update_status = mysqli_query($connect, "UPDATE `key` SET key_Status = '$key_status' WHERE key_id = '$key_id'");

   $message[] = 'Key Registration Status Has Updated!';

}
?>

<!DOCTYPE html>
<html lang="en">
 <head>
    <title>Messages</title>

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

/* main */

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


.table-title a {
	float:right;
}


table.table tr th, table.table tr td {
	border-color: #e9e9e9;
	padding: 15px 20px;
	vertical-align: middle;
}



.ri-edit-box-fill, .ri-delete-bin-fill{
	font-size:23px;
}

.ri-delete-bin-fill{
	color:red;
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

/* edit */
.message-container {
   position: fixed;
   top: 0;
   left: 0;
   z-index: 1100;
   background-color: white;
   padding: 2rem;
   align-items: center;
   justify-content: center;
   min-height: 100vh;
   width: 100%;
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

message-container form .row{
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
   font-size: 1.4rem;
   padding:.8rem 2rem;
   border-radius: 0.5rem;
   cursor: pointer;
   margin-top: 1rem;
   text-decoration: none;
   font-family:Average;
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

.drop-down {
    width: 100px;
    height: 35px;
    font-size: 15px;
    font-family: Average;
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

    <!-- View Messages of Resident Requested Key -->
	<div class="message-container">

   <form action="" method="post">
    <p style="font-size:40px; font-weight:bold; font-family:Comic Sans Mc; text-align:left;"> Messages</p>
	<hr style="margin-bottom:10px; color:black;"/>
       <table class="table">
				<thead>
					<tr>
						<th>Key Requested Name</th>
						<th>Key Requested Email</th>
						<th>Key Requested Number</th>
						<th>Key Requested Date</th>
						<th>Key Requested Unit</th>
						<th>Key Requested Status</th>
						<th></th>
					</tr>
				</thead>
				<?php
					$results = mysqli_query($connect, "SELECT * FROM `key`");
					if(mysqli_num_rows($results) > 0){
					while($row = mysqli_fetch_assoc($results)){
			?>
				<tbody>
					<tr>
						<td><?php echo $row['key_requestedName']; ?></td>
						<td><?php echo $row['key_requestedEmail']; ?></td>
						<td><?php echo $row['key_requestedNumber']; ?></td>
						<td><?php echo $row['key_DateRegistered']; ?></td>
						<td><?php echo $row['key_unitNumber']; ?></td>
						
						<form action="" method="POST">
						<input type="hidden" name="key-id" value="<?= $row['key_id']; ?>">
						<td class="status">
						<select name="key-status" class="drop-down">
							<option value="" selected disabled><?= $row['key_Status']; ?></option>
							<option value="Pending">Pending</option>
							<option value="Successfully">Successfully</option>
							<option value="Rejected">Rejected</option>
						</select></td>
						<div class="flex-btn">
							<td><i class="ri-delete-bin-fill"></i><a href="view_message.php?deleteMessage=<?= $row['key_id']; ?>"  class="Deletebtn" onclick="return confirm('Are You Sure You Want To Delete This Resident Message?');">Delete</a></td></td>
							<td><button type="submit" style="cursor: pointer;" class="Updatebtn" name="update-status"><i class="ri-edit-box-fill"></i> Update</button></td>
						</div>
						</form>			
					</tr>							
				</tbody>
			<?php
				};
					}
				else
				{
					echo '<p class="empty">No Messages Yet!</p>';
				}
				?>
			</table>
			<a href="manage_keyRegistration.php" style="width:100%;"  class="option-button">Cancel <i class="ri-close-circle-fill"></i></a>
   </form>
	</div>

	</div>

  </body>
</html>
