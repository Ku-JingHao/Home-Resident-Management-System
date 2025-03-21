<?php include("data_connection.php");

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_SESSION['success_message'])){ // Check for success message in the session
    echo '<div class="success-message">'.$_SESSION['success_message'].'</div>';
    unset($_SESSION['success_message']); // Clear the success message from the session to show it only once
}

if(isset($_POST['btnSubmit'])){
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $unit = $_POST['unit'];
   $unit = filter_var($unit, FILTER_SANITIZE_STRING);
   $gendertype = $_POST['gendertype'];
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   
   $select_resident = mysqli_query($connect, "SELECT * FROM `resident` WHERE resident_number = '$number' OR resident_email = '$email' ");
   $row = mysqli_fetch_assoc($select_resident);
	
   if(mysqli_num_rows($select_resident) > 0)
   {
      $message[] = 'Email or Phone Number already exists!';
   }
   else{
		 $insert_query = mysqli_query($connect, "INSERT INTO `resident`(resident_name, resident_email, resident_number, resident_unit, resident_gender, resident_password) 
		 VALUES('$name', '$email', '$number', '$unit', '$gendertype', '$pass')");
		 
		 $select_resident = mysqli_query($connect, "SELECT * FROM `resident` WHERE resident_email = '$email' AND resident_password = '$pass'");
		 $row = mysqli_fetch_assoc($select_resident);
		 
          if(mysqli_num_rows($select_resident) > 0){
            $_SESSION['user_id'] = $row['resident_id'];
            $_SESSION['success_message'] = 'Account Registered Successfully!';
			$message[] = 'Account Registered Sucessfully!';
         }
   }

}
?>

<!DOCTYPE html>

 <head>
    <title>Add Residents</title>

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
.register__title{
font-family:Average;
}

.cancelBtn{
	font-size:15px;
	border: 2px solid red;
	text-decoration:none;
	color:white;
	background-color:red;
	padding: 13px;
	margin-top: .5rem;
	border-radius: 4rem;
	font-weight: 500;
	cursor: pointer;
	width: 100%;
    text-align: center;
    display: inline-block;
    font-size: 18px;
	font-family:Average;
}

.register__input {
  font-size: 18px; /* Set the font size for the entire select element */
  font-family:Average;
}

.register__input option {
  font-size: 17px; /* Set the font size for individual options */
  background-color:black;
}

.main-container{
margin-left:320px;
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
        <div class="register">
         <form name="RegistrationFrm" method="post" method="post" action="#" class="register__form">
            <h1 class="register__title">Register Residents</h1>
            <div class="register__inputs">
			   <div class="register__box">
				  <input type="text" id="FirstName" name="name" class="register__input " placeholder="Enter Resident's Name*"required>
                  <i class="ri-user-line"></i>
               </div>
               <div class="register__box">
                  <input type="email" name="email" placeholder="Enter Resident's Email*" class="register__input" required>
                  <i class="ri-mail-fill"></i>
               </div>
			   <div class="register__box">
				  <input type="tel" name="number" pattern="[0-9]{3}-[0-9]{7}" placeholder="Enter Resident's Phone Number*" class="register__input" required/>
                  <i class="ri-phone-line"></i>
               </div> 
			   <div class="register__box">
			   <select class="register__input" name="unit" required>
				<option value="A-1">A-1</option>
				<option value="A-2">A-2</option>
				<option value="A-3">A-3</option>
				<option value="A-4">A-4</option>
				<option value="A-5">A-5</option>
				<option value="A-6">A-6</option>
				</select>
                  <i class="ri-home-4-fill"></i>
               </div>
			    <div class="register__box">
			    <select class="register__input" name="gendertype">
				<option value="Male">Male </option>
				<option value="Female">Female</option>
				</select>
				<i class="ri-genderless-line"></i>
				</div>
               <div class="register__box">
                  <input type="password" placeholder="Set It As Default Password : 111" name="pass" title="Default Password : 111" required class="register__input">
                  <i class="ri-lock-2-line"></i>	  
               </div>
            </div>
            <button type="submit" name="btnSubmit" class="register__button">Register <i class="ri-registered-line"></i></button> 
			<a href="manage_resident.php" class="cancelBtn">Cancel <i class="ri-close-circle-fill"></i></a>
         </form>
      </div>
				
      </main>
      <!-- End Main -->

    </div>
  </body>
</html>