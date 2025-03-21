<?php include("data_connection.php");

session_start();

if(isset($_SESSION['admin_id'])){
   $admin_id = $_SESSION['admin_id'];
}else{
   $admin_id = '';
};


if(isset($_POST['btnSubmit'])){

   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $select_prev_pass = mysqli_query($connect, "SELECT admin_password FROM `admin` WHERE admin_id = '$admin_id'");
   $fetch_prev_pass = mysqli_fetch_assoc($select_prev_pass);
   $prev_pass = $fetch_prev_pass['admin_password'];
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $confirm_pass = sha1($_POST['cpass']);
   $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

   if($old_pass != $empty_pass)
   {
      if($old_pass != $prev_pass)
	  {
         $message[] = 'Old Password Not Matched!';
      }
	  else if($new_pass != $confirm_pass)
	  {
         $message[] = 'Confirm Password Not Matched!';
      }
	  
	  else if($new_pass == $old_pass)
	  {
         $message[] = 'Enter A New Password';
      }
	  
	  else
	  {
         if($new_pass != $empty_pass)
		 {
			$update_pass = mysqli_query($connect, "UPDATE `admin` SET admin_password = '$confirm_pass' WHERE admin_id = '$admin_id'");
            $message[] = 'Password Has Been Updated Successfully!';
         }
		 else
		 {
            $message[] = 'Please Enter A New Password!';
         }
      }
   } 

}
?>

<!DOCTYPE html>
<html>
 <head>
    <title>Admin Change Password</title>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">
	<link rel="stylesheet" href="css/styles.css" />
<style>
<?php include'css/styles.css';?>
body {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  color: rgb(70, 71, 81);
   font-family:Average;
  background: url(image/admin_bg.jpg);
}


/* change password form*/
.form {	
	  width:800px;
	  display: flex;
	  justify-content: center;
	  margin: 0 auto;
	  margin-top:50px;
	  color:white;
	  border:1px solid white;
	  padding-bottom:20px;
}

.password{
	width: 100%;
	height: 50px;
	padding: 10px 20px;
	margin: 5px 0;
	display: inline-block;
	border: 1px solid white;
	box-sizing: border-box;
}


.form h4{
	font-size:50px;
	color: #DCDCDC;
	margin-top: 30px;
	margin-bottom: 10px;
}

.back_btn{
	 border: 1px solid white;
	background: transparent;
	color: white;
	display: block;
	line-height: 45px;
	width:220px;
	font-size: 20px;
	text-decoration:none;
	text-align:center;
	font-family:Average;
}

.register_btn{
    border: 1px solid white;
	background: transparent;
	color: white;
	display: block;
	line-height: 45px;
	width:220px;
	font-size: 20px;
	font-family:Average;
}

.register_btn:hover, .back_btn:hover{

	background: white;
    color: black;
	cursor: pointer;
}

.form p{
	font-size:20px;
	 margin-bottom: 20px;
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
	<section class="pass-form">
		<div class="form">
		<form name="RegistrationFrm" method="post" action="#">
		<h4>Change Password <i class="ri-lock-password-fill"></i></h4>
		<p><b>Old Password</b> :<br/><input type="password" name="old_pass" placeholder="Enter Your Old Password" class="password" required/></p>
		<p><b>New Password (at least three character and three digits)</b><br/><input type="password"  name="new_pass" pattern="^(?=.*[A-Za-z]{3})(?=.*\d{3}).{6,}$" placeholder="Create Your Password*" title="At Least Three Character and Three Digit"  class="password" required/></p>
		<p><b>Confirm New Password</b> :<br/><input type="password"  name="cpass" placeholder="Confirm Your Password*" class="password" required/></p>
		<p><input type="submit" name="btnSubmit" value="Change Password &#x2192" class="register_btn"></p>
		<a href="admin_profile.php" class="back_btn">Back To Profile </a>	
		</form>
		</div>
	</section>
	</div>
  </body>
</html>