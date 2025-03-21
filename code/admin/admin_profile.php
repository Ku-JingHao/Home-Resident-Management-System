<?php include("data_connection.php");

session_start();

if(isset($_SESSION['admin_id'])){
   $admin_id = $_SESSION['admin_id'];
}else{
   $admin_id = '';
};

if(isset($_POST['update_profile'])){
   $update_id = $_POST['update_id'];
   $update_name = $_POST['update_name'];
   $update_name = filter_var($update_name, FILTER_SANITIZE_STRING);
   $update_email = $_POST['update_email'];
   $update_email = filter_var($update_email, FILTER_SANITIZE_STRING);
   $update_number = $_POST['update_number'];
   $update_number = filter_var($update_number, FILTER_SANITIZE_STRING);

   
   if(!empty($update_name)){
      $update_names = mysqli_query($connect, "UPDATE `admin` SET admin_name = '$update_name' WHERE admin_id = '$admin_id'");
	  $message[] = 'Update Succesfully';
   }

   if(!empty($update_email)){
      $select_email = mysqli_query($connect, "SELECT * FROM `admin` WHERE admin_email = '$update_email'");
	  if(mysqli_num_rows($select_email) > 0)
	  {
         $message[] = 'Email Already Taken!';
      }
	  
	  else{
         $update_emails = mysqli_query($connect, "UPDATE `admin` SET admin_email = '$update_email' WHERE admin_id = '$admin_id'");
		 $message[] = 'Update Succesfully';
      }
   }

   if(!empty($update_number))
   {
      $select_number = mysqli_query($connect, "SELECT * FROM `admin` WHERE admin_number = '$update_number'");

       if(mysqli_num_rows($select_number) > 0)
	  {
         $message[] = 'Number Already Taken!';
      }
	  else
	  {
         $update_numbers =  mysqli_query($connect, "UPDATE `admin` SET admin_number = '$update_number' WHERE admin_id = '$admin_id'");
		 $message[] = 'Update Succesfully';
      }
   }
   
   
};

?>

<!DOCTYPE html>
<html>
 <head>
    <title>Admin Profile</title>

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
.container {
	width: 1200px;
	max-width: 100%;
	padding: 0px 3%;
	margin: 0 auto;
	margin-top:90px;
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





/* profile */
.title{
	text-align:center;
	font-family: Average;
	font-size:50px;
	color:white;
	margin-bottom:20px;
}

.user{
	font-family: Average;
	border : 1px solid grey;
	width: 45%;
	background-color: #EEEEEE;
	color:black;
	text-align:center;
	margin:0 auto;
	padding-top:30px;
	padding-bottom:40px;
	font-size:23px;
	border-radius:30px;
	border-top-width: 2px;
    border: 2px solid #C27BA0;
    border-top-right-radius: 10px;
    border-top-left-radius: 30px;
    border-bottom-right-radius: 50px;
    border-bottom-left-radius: 100px;
}

.user p {
    margin-bottom: 13px;
}

.user img{
	width:200px;
	height:200px;
	margin:auto;
	margin-bottom:15px;
}

.Updatebtn{
		background-color: #45818E;
        line-height: 50px;
        margin-top: 10px;
        padding-left: 30px;
        padding-right: 30px;
        border: none;
        color: #fff;
        display: inline-block;
        font-size: 23px;
        font-weight: bold;
        position: relative;
		cursor: pointer;
		text-decoration:none;
}

.Updatebtn:hover, .changebtn:hover{
	background-color:#76A5AF;
	color:white;
}

.changebtn{
	background-color: #45818E;
	margin-left:10px;
	padding:0 8px 0 8px ;
        line-height: 50px;
        border: none;
        color: #fff;
        display: inline-block;
        font-size: 25px;
        font-weight: bold;
        position: relative;
		cursor: pointer;
		text-decoration:none;
}

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
   width: 45rem;
   border-radius: .5rem;
   background-color: white;
   text-align: center;
   padding:2rem;
   overflow-y: auto; /* Add this property to make the container scrollable */
   max-height: 80vh; /* Set a max height if needed */
}

.update-container form .row{
   width:100%;
   background-color: white;
   border-radius: .5rem;
   margin:1rem 0;
   font-size: 20px;
   color:black;
   padding:1.2rem 1.4rem;
   text-transform: none;
   font-family:Average;
}

.update-container form span{
   font-size: 20px;
   font-family:Average;
}

.button,.option-button,.delete-button{
   display: block;
   width: 100%;
   text-align: center;
   background-color: #2E8B57;
   color:white;
   font-size: 1.3rem;
   padding:1.2rem 3rem;
   border-radius: 0.5rem;
   cursor: pointer;
   margin-top: 1rem;
   text-decoration: none;
  font-family:Average;
}

.option-button,.delete-button{
	width: 50%;
}

.button:hover{
   background-color: #86BF99;
}

.option-button:hover{
	background-color:#E06666;
}


.option-button{
	background-color: red;
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
	<section class="user-details">

   <h1 class="title">My Profile</h1>

   <div class="box-container">
	<?php
      $results = mysqli_query($connect, "SELECT * FROM `admin` WHERE admin_id = '$admin_id'");
	  if ($results) {
          $row_view = mysqli_fetch_assoc($results); 
   ?>
   <div class="user">
      <img src="Image/user-icon.png" alt="">
      <p><b>Name  : </b><span style="color:#674EA7;"><?php echo $row_view['admin_name']; ?></span></p>
	  <p><b>Email : </b><span style="color:#674EA7;"><?php echo $row_view['admin_email']; ?></span></p>
	  <p><b>Phone Number : </b><span style="color:#674EA7;"><?php echo $row_view['admin_number']; ?></span></p>
      <form action="" method="POST">
	  <input type="hidden" name="admin-id" value="<?= $row_view['admin_id']; ?>">
		  <div class="flex-btn">
			<a href="admin_profile.php?updated=<?php echo $row_view['admin_id']; ?>" class="Updatebtn">Update Profile</a>	
			<a href="admin_changePassword.php" class="changebtn">Change Password</a>	
		  </div>
	  </form>
   </div>
   </div>
    <?php
      }
   ?>
</section>



</div>
				
      </main>
      <!-- End Main -->
	
	<!-- Update Admin -->
	<div class="update-container">
	
	<?php
   
   if(isset($_GET['updated'])){
      $update_acc = $_GET['updated'];
      $update_query = mysqli_query($connect, "SELECT * FROM `admin` WHERE admin_id = $update_acc");
      if(mysqli_num_rows($update_query) > 0)
	  {
         while($row_update= mysqli_fetch_assoc($update_query))
		 {
   ?>
  
   <form action="" method="post" enctype="multipart/form-data">
	  <p style="font-size:35px; color:black; font-weight:bold; font-family:Comic Sans Mc;"> Update Your Profile </p>
	  <input type="hidden" name="update_id" value="<?php echo $row_update['admin_id']; ?>">
      <span>Username :</span><input type="text" class="row" name="update_name" value="<?php echo $row_update['admin_name']; ?>"> <br>
	  <span>Email Address :</span><input type="email" class="row" required name="update_email" value="<?php echo $row_update['admin_email']; ?>"> <br>
	  <span>Phone Number :</span><input type="tel" required name="update_number" class="row" value="<?php echo $row_update['admin_number']; ?>"> <br>
      <input type="submit" value="Update Profile" name="update_profile" class="button">
      <input style="width:100%;" type="reset" value="Cancel" id="close-edit" class="option-button">
   </form>
  
  <?php
            };
         };
         echo '<script>document.addEventListener("DOMContentLoaded", function() {
    // Get the elements
    var updateBtn = document.querySelector(".Updatebtn");
    var updateContainer = document.querySelector(".update-container");

    // Add click event listener to the "Update Profile" button
    updateBtn.addEventListener("click", function(event) {
      // Prevent the default link behavior
      event.preventDefault();

      // Toggle the visibility of the update container
      updateContainer.style.display = (updateContainer.style.display === "none" || updateContainer.style.display === "") ? "flex" : "none";
    });

    // Add click event listener to the "Cancel" button inside the update container
    var closeEditBtn = document.getElementById("close-edit");
    if (closeEditBtn) {
      closeEditBtn.addEventListener("click", function(event) {
        // Prevent the default button behavior
        event.preventDefault();

        // Hide the update container
        updateContainer.style.display = "none";
      });
    }
  });
		 </script>';
      };
   ?>
</div>
    </div>
  </body>
</html>