<?php include("data_connection.php");

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['update_profile'])){
   $update_id = $_POST['update_id'];
   $update_name = $_POST['update_name'];
   $update_name = filter_var($update_name, FILTER_SANITIZE_STRING);
   $update_email = $_POST['update_email'];
   $update_email = filter_var($update_email, FILTER_SANITIZE_STRING);
   $update_number = $_POST['update_number'];
   $update_number = filter_var($update_number, FILTER_SANITIZE_STRING);
   $update_address = $_POST['update_address'];
   $update_address = filter_var($update_address, FILTER_SANITIZE_STRING);
   
   if(!empty($update_name)){
      $update_names = mysqli_query($connect, "UPDATE `resident` SET resident_name = '$update_name' WHERE resident_id = '$user_id'");
	  $message[] = 'Update Succesfully';
   }
   if(!empty($update_email)){
      $select_email = mysqli_query($connect, "SELECT * FROM `resident` WHERE resident_email = '$update_email'");
	  if(mysqli_num_rows($select_email) > 0){
         $message[] = 'Email Already Taken!';
      }
	  else{
         $update_emails = mysqli_query($connect, "UPDATE `resident` SET resident_email = '$update_email' WHERE resident_id = '$user_id'");
		 $message[] = 'Update Succesfully';
      }
   }
   if(!empty($update_number)){
      $select_number = mysqli_query($connect, "SELECT * FROM `resident` WHERE resident_number = '$update_number'");

       if(mysqli_num_rows($select_number) > 0)
	  {
         $message[] = 'Number Already Taken!';
      }
	  else
	  {
         $update_numbers =  mysqli_query($connect, "UPDATE `resident` SET resident_number = '$update_number' WHERE resident_id = '$user_id'");
		 $message[] = 'Update Succesfully';
      }
	}
     if(!empty($update_address)){
      $update_address = mysqli_query($connect, "UPDATE `resident` SET resident_unit = '$update_address' WHERE resident_id = '$user_id'");
	  $message[] = 'Update Succesfully';
	}
};
?>

<!DOCTYPE html>
<html>
<head>
	<title>Resident Update Profile Page</title>

	<link rel="stylesheet" href="css/resident_main.css" />

  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
<?php include'css/resident_main.css';?>
.landing {
	width: 100%;
	height: 100%;
	position: relative;
}

* {
	box-sizing: border-box;
	padding: 0;
	margin: 0;
}

body {
	background: url(image/background.png);
	background-color: rgba(39, 39, 39, .7);
	background-blend-mode: color-burn;
	background-repeat: no-repeat;
	background-position: left center;
	background-size: cover;
	font-family: 'Poppins', sans-serif;
	font-size: 16px;
	font-weight: normal;
	line-height: 1.5;
	width: 100%;
	overflow-x: hidden;
}

h1 {
	line-height: 1.1;
}

/*end body*/

.profile-btn:hover{
	background-color:#FFD966;
	color:white;
}

.profile-btn{
	display: inline-block;
   font-size: 25px;
   cursor: pointer;
	 background-color:#F1C232;
}

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
	width:35%;
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
	<section class="landing">
	<?php include 'header.php'; ?>
	
	<section class="user-details">
   <h1 class="title">My Profile</h1>
   <div class="box-container">
	<?php
      $results = mysqli_query($connect, "SELECT * FROM `resident` WHERE resident_id = '$user_id'");
	  if ($results) {
          $row_view = mysqli_fetch_assoc($results); 
   ?>
   <div class="user">
      <img src="Image/user-icon.png" alt="">
      <p><b>Name  : </b><span style="color:#674EA7;"><?php echo $row_view['resident_name']; ?></span></p>
	  <p><b>Email : </b><span style="color:#674EA7;"><?php echo $row_view['resident_email']; ?></span></p>
	  <p><b>Phone Number : </b><span style="color:#674EA7;"><?php echo $row_view['resident_number']; ?></span></p>
	  <p><b>Unit Number : </b><span style="color:#674EA7;"><?php echo $row_view['resident_unit']; ?></span></p>
	  <p><b>Gender : </b><span style="color:#674EA7;"><?php echo $row_view['resident_gender']; ?></span></p>
      <form action="" method="POST">
	  <input type="hidden" name="resident-id" value="<?= $row_view['resident_id']; ?>">
		  <div class="flex-btn">
			<a href="update_profile.php?updated=<?php echo $row_view['resident_id']; ?>" class="Updatebtn">Update Profile</a>	
			<a href="change_password.php" class="changebtn">Change Password</a>	
		  </div>
	  </form>
   </div>
   </div>
    <?php
      }
   ?>
</section>
</section>

<div class="update-container">
	<?php
   if(isset($_GET['updated'])){
      $update_acc = $_GET['updated'];
      $update_query = mysqli_query($connect, "SELECT * FROM `resident` WHERE resident_id = $update_acc");
      if(mysqli_num_rows($update_query) > 0)
	  {
         while($row_update= mysqli_fetch_assoc($update_query))
		 {
   ?>
  
   <form action="" method="post" enctype="multipart/form-data">
	  <p style="font-size:35px; color:black; font-weight:bold; font-family:Comic Sans Mc;"> Update Your Profile </p>
	  <input type="hidden" name="update_id" value="<?php echo $row_update['resident_id']; ?>">
      <span>Username :</span><input type="text" class="row" name="update_name" value="<?php echo $row_update['resident_name']; ?>"> <br>
	  <span>Email Address :</span><input type="email" class="row" name="update_email" value="<?php echo $row_update['resident_email']; ?>"> <br>
	  <span>Phone Number :</span><input type="tel" name="update_number" class="row" value="<?php echo $row_update['resident_number']; ?>"> <br>
	  <span>Unit Number:</span>
	  <select class="row" name="update_address">
		<option value="" selected disabled><?= $row_update['resident_unit']; ?></option>
		<option value="A-1">A-1</option>
		<option value="A-2">A-2</option>
		<option value="A-3">A-3</option>
		<option value="A-4">A-4</option>
		<option value="A-5">A-5</option>
		<option value="A-6">A-6</option>
	  </select><br>
      <input type="submit" value="Update Profile" name="update_profile" class="button">
      <input style="width:100%;" type="reset" value="Cancel" id="close-edit" class="option-button">
   </form>
  
  <?php
            };
         };
         echo '
            <script src="js/script.js"></script>';
      };
   ?>
</div>
</body>
</html>