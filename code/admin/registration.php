<?php include("data_connection.php");

session_start();

if(isset($_SESSION['admin_id'])){
   $admin_id = $_SESSION['admin_id'];
}else{
   $admin_id = '';
};

// Check for success message in the session
if(isset($_SESSION['success_message'])){
    echo '<div class="success-message">'.$_SESSION['success_message'].'</div>';
    // Clear the success message from the session to show it only once
    unset($_SESSION['success_message']);
}

if(isset($_POST['btnSubmit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
   
   $select_admin = mysqli_query($connect, "SELECT * FROM `admin` WHERE admin_number = '$number' OR admin_email = '$email' ");
   $row = mysqli_fetch_assoc($select_admin);
	
   if(mysqli_num_rows($select_admin) > 0){
      $message[] = 'Email or Phone Number already exists!';
   }
   else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }
	  else{
		 $insert_query = mysqli_query($connect, "INSERT INTO `admin`(admin_name, admin_email, admin_number, admin_password) 
		 VALUES('$name', '$email', '$number', '$cpass')");
		 
		 $select_admin = mysqli_query($connect, "SELECT * FROM `admin` WHERE admin_email = '$email' AND admin_password = '$pass'");
		 $row = mysqli_fetch_assoc($select_admin);
		 
          if(mysqli_num_rows($select_admin) > 0){
            $_SESSION['admin_id'] = $row['admin_id'];
			$_SESSION['success_message'] = 'Account Registered Successfully!';
            header('location:login.php');
         }
      }
   }
}
?>

<!DOCTYPE html>
   <html>
   <head>

      <!--=============== REMIXICONS ===============-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">

      <!--=============== CSS ===============-->
      <link rel="stylesheet" href="css/styles.css">

      <title>Admin Registration Page</title>
	 <style>
	<?php include'css/styles.css';?>
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
	
      <div class="register">
         <img src="image/admin_bg.jpg" alt="image" class="register__bg">

         <form name="RegistrationFrm" method="post" action="#"  class="register__form">
            <h1 class="register__title">Registration Form</h1>

            <div class="register__inputs">
			   <div class="register__box">
				  <input type="text" id="FirstName" name="name" class="register__input " placeholder="Enter Your Name*"required>
                  <i class="ri-user-line"></i>
               </div>
               <div class="register__box">
                  <input type="email" name="email" placeholder="Enter Your Email*" class="register__input" required>
                  <i class="ri-mail-fill"></i>
               </div>
			   <div class="register__box">
				  <input type="tel" name="number" pattern="[0-9]{3}-[0-9]{7}" placeholder="Enter Your Phone Number*" class="register__input" required/>
                  <i class="ri-phone-line"></i>
               </div>
               <div class="register__box">
                  <input type="password" placeholder="Create Your Password* (at least three character and three digits)" name="pass" pattern="^(?=.*[A-Za-z]{3})(?=.*\d{3}).{6,}$" title="At Least Three Character and Three Digit" required class="register__input">
                  <i class="ri-lock-2-line"></i>	  
               </div>
			   <div class="register__box">
                  <input type="password" name="cpass" placeholder="Confirm Your Password*" required class="register__input">
                  <i class="ri-lock-2-fill"></i>
               </div>
            </div>

            <div class="register__check">
               <div class="register__check-box">
                  <input type="checkbox" class="register__check-input" id="user-check">
                  <label for="user-check" class="register__check-label">Remember me</label>
               </div>
               <a href="#" class="register__forgot">Forgot Password?</a>
            </div>
            <button type="submit" name="btnSubmit" class="register__button">Register <i class="ri-registered-line"></i></button> 
			<div class="register__login">
                Proceed To <a href="login.php">Login</a>
			   <i class="ri-login-box-line"></i>
            </div>
         </form>
      </div>
   </body>
</html>