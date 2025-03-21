<?php include("data_connection.php");

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

// Check for success message in the session
if (isset($_SESSION['success_message'])) {
   echo '<div class="message"><span>' . $_SESSION['success_message'] . '</span> <i class="alert-message" onclick="this.parentElement.style.display = `none`;">
	  <img src="image/cross.png" alt="" class="cross-icon"></i> </div>';
    // Clear the success message from the session to show it only once
    unset($_SESSION['success_message']);
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Resident Landing Page</title>

	<link rel="stylesheet" href="css/resident_main.css" />

  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">
<style>
<?php include'css/resident_main.css';?>
.landing {
	width: 100%;
	height: 100vh;
	position: relative;
}

body{
	background: url(image/background.png);
	background-color: rgba(39, 39, 39, .7);
	background-blend-mode: color-burn;
	background-repeat: no-repeat;
	background-position: left center;
	background-size: cover;
}

@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
* {
	box-sizing: border-box;
	padding: 0;
	margin: 0;
}

body {
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

/* Ends basic desing */
</style>
</head>
<body>	
	<section class="landing">
	<header>
			<div class="container">
				<div class="logo">
					<h2><a href="#"><span></span>Residence Management System</a></h2>
				</div>
				<nav>
					<div class="hamb">
						<span class="line"></span>
						<span class="line"></span>
						<span class="line"></span>
					</div>

					<ul class="nav-up">
						<li class="active"><a href="resident_landing.php">Home <i class="ri-home-8-line"></i></a></li>
						<li><a href="update_profile.php">Profile <i class="ri-profile-line"></i></a></li>
						<li><a href="resident_keyRequest.php">Key <i class="ri-key-fill"></i></a></li>
						<li><a href="SubmitfeedbackComplaintsPhotos.php">Feedback <i class="ri-feedback-line"></i></a></li>
						<li><a href="GenerateQrCode.php">QrCode <i class="ri-qr-code-line"></i></a></li>
						<li class="logout"><a href="resident_logout.php" onclick="return confirm('Logout From This Website?');" style="color: #CCCCCC;">LogOut <i class="ri-logout-circle-fill"></i></a></li>
					</ul>
				</nav>
			</div>
		</header>
		
	
		<section class="banner">
			<div class="container">
				<div class="details">
					<h1>Welcome To Your Profile</h1>
					<p style="font-size:19px;">Dear Resident, if you encounter any issues, please feel free to reach out to us. We are here to help and optimize your experience.</p>
				</div>
				<div class="event">
					<a href="resident_event.php">Latest Events</a>
					<i class="ri-arrow-left-circle-line"> Check The Latest Events Now</i>
				</div>				
			</div>
		</section>
	</section>

	<script src="js/script.js"></script>

</body>
</html>