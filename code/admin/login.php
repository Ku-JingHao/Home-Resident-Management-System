<?php include("data_connection.php");

session_start();

if(isset($_SESSION['admin_id'])){
   $admin_id = $_SESSION['admin_id'];
}else{
   $admin_id = '';
};

// Check for success message in the session
if (isset($_SESSION['success_message'])) {
   echo '<div class="message"><span>' . $_SESSION['success_message'] . '</span> <i class="alert-message" onclick="this.parentElement.style.display = `none`;">
	  <img src="image/cross.png" alt="" class="cross-icon"></i> </div>';
    // Clear the success message from the session to show it only once
    unset($_SESSION['success_message']);
}

if(isset($_POST['btnSubmit'])){

   $email = $_POST['staff-email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $password = sha1($_POST['staff-pass']);
   $password = filter_var($password, FILTER_SANITIZE_STRING);

   $select_admin = mysqli_query($connect, "SELECT * FROM `admin` WHERE admin_email = '$email' AND  admin_password = '$password'");
   $row = mysqli_fetch_assoc($select_admin);
	
   if(mysqli_num_rows($select_admin) > 0){
    $_SESSION['admin_id'] = $row['admin_id'];
    $_SESSION['success_message'] = 'Login Successfully!';
    header('location:admin_landing.php');
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
      <link rel="stylesheet" href="css/styles.css">

      <title>Admin Login Page</title>
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
      <div class="login">
         <img src="image/admin_bg.jpg" alt="image" class="login__bg">
         <form name="RegistrationFrm" method="post" action="" class="login__form">
            <h1 class="login__title">Login</h1>
            <div class="login__inputs">
               <div class="login__box">
                  <input type="email" placeholder="Email ID" name="staff-email" required class="login__input">
                  <i class="ri-mail-fill"></i>
               </div>

               <div class="login__box">
                  <input type="password" placeholder="Password" name="staff-pass" required class="login__input">
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
            <button type="submit" name="btnSubmit" class="login__button" >Login<i class="ri-login-box-line"></i></button>
            <div class="login__register">
               Don't have an account? <a href="registration.php">Register</a>
			   <i class="ri-registered-line"></i>
            </div>
         </form>
      </div>
   </body>
</html>