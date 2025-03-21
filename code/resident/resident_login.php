<?php include("data_connection.php");
session_start();

// Check for success message in the session
if (isset($_SESSION['success_message'])) {
   echo '<div class="message"><span>' . $_SESSION['success_message'] . '</span> <i class="alert-message" onclick="this.parentElement.style.display = `none`;">
	  <img src="image/cross.png" alt="" class="cross-icon"></i> </div>';
    // Clear the success message from the session to show it only once
    unset($_SESSION['success_message']);
}

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['btnLogin'])){
   $email = $_POST['resident-email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $password = sha1($_POST['resident-pass']);
   $password = filter_var($password, FILTER_SANITIZE_STRING);

   $select_resident = mysqli_query($connect, "SELECT * FROM `resident` WHERE resident_email = '$email' AND  resident_password = '$password'");
   $row = mysqli_fetch_assoc($select_resident);
	
   if(mysqli_num_rows($select_resident) > 0){
    $_SESSION['user_id'] = $row['resident_id'];
    $_SESSION['success_message'] = 'Login Successfully!';
    header('location:resident_landing.php');
    exit(); // Add this line to stop the script execution after the redirect
}else{
    $message[] = 'Incorrect Email or Password!';
}
}
?>

<!DOCTYPE html>
   <html>
   <head>

      <!--=============== REMIXICONS ===============-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">

      <!--=============== CSS ===============-->
      <link rel="stylesheet" href="css/resident_main.css">

      <title>Resident Login Page</title>
	  <style>
	  body{
		  background-image: url("image/main_background.jpg");
		  background-size: cover; 
		  background-repeat: no-repeat;
		  background-position-x: center;
		  background-position-y: center;
		}

	 <?php include'css/resident_main.css';?>
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
      <div class="login">
         <img class="login__bg">

         <form method="post" action="" class="login__form">
            <h1 class="login__title">Login</h1>

            <div class="login__inputs">
               <div class="login__box">
                  <input type="email" name="resident-email" placeholder="Email ID" required class="login__input">
                  <i class="ri-mail-fill"></i>
               </div>

               <div class="login__box">
                  <input type="password" name="resident-pass" placeholder="Password" required class="login__input">
                  <i class="ri-lock-2-fill"></i>
               </div>
            </div>

            <div class="login__check">
               <div class="login__check-box">
                  <input type="checkbox" class="login__check-input" id="user-check">
                  <label for="user-check" class="login__check-label">Remember me</label>
               </div>

               <a href="#" class="login__forgot">Forgot Password?</a>
            </div>

            <button type="submit" name="btnLogin"  class="login__button" >Login<i class="ri-login-circle-line"></i></button>
         </form>
      </div>
   </body>
</html>