<?php include("data_connection.php");

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

// Check for success message in the session
if(isset($_SESSION['success_message'])){
    echo '<div class="success-message">'.$_SESSION['success_message'].'</div>';
    // Clear the success message from the session to show it only once
    unset($_SESSION['success_message']);
}

if (isset($_POST['btnSubmit'])) {
    $visitor_type = $_POST['visitorType'];
    $visitor_name = $_POST['name'];
    $visitor_email = $_POST['email'];
    $visitor_number = $_POST['number'];
    $visit_date = $_POST['visitDate'];
    $visit_purpose = $_POST['visitPurpose'];
    $resident_name = $_POST['residentName'];
    $resident_unit = $_POST['residentUnit'];

    $insert_query = mysqli_query($connect, "INSERT INTO `visitor` 
        (visitor_type, visitor_name, visitor_email, visitor_number, visit_date, visit_purpose, resident_name, resident_unit)
        VALUES 
        ('$visitor_type', '$visitor_name', '$visitor_email', '$visitor_number', '$visit_date', '$visit_purpose', '$resident_name', '$resident_unit')");

    if ($insert_query) {
		$_SESSION['success_message'] = 'Visitor Registration Added Successfully!';
		 header("Location: ManageVisitorRegistration.php");
		exit(); // Add this line to stop the script execution after the redirect
    } else {
        $message[] = 'Error adding visitor registration: ' . mysqli_error($connect);
    }
 
}

?>

<!DOCTYPE html>

 <head>
    <title>Add Visitor</title>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">
	<link rel="stylesheet" href="css/styles.css" />
<style>
<?php include'css/styles.css';?>
body {
  /* Add the following styles to center the form vertically */
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100vh;
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

.register__form {
  margin: 0 auto; /* Center the form horizontally */
  max-width: 600px; /* Adjust the maximum width as needed */
}

.main-container {
  display: flex;
  align-items: center;
  justify-content: center;
}


.register__box input[type="date"] {
  font-size: 18px;
  font-family: Average;
}


.register__box input[type="date"]::-webkit-calendar-picker-indicator {
  filter: invert(1); /* Invert the color of the icon (for better visibility) */
	right:0;
}

i{
	 margin-right: 12px; 
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


      <!-- Main -->
      <main class="main-container">
        <div class="register">
         <form name="RegistrationFrm" method="post" method="post" action="#" class="register__form">
            <h1 class="register__title">Register Visitor</h1>

            <div class="register__inputs">
			
				<div class="register__box">
				<select id="visitorType" class="register__input" name="visitorType" required>
                    <option value="Registered">Registered</option>
                     <option value="Scheduled">Scheduled</option>
                </select>
				</div>
				
			   <div class="register__box">
				  <input type="text" id="FirstName" name="name" class="register__input " placeholder="Enter Visitor's Name*"required>
                  <i class="ri-user-line"></i>
               </div>
			
               <div class="register__box">
                  <input type="email" name="email" placeholder="Enter Visitor's Email*" class="register__input" required>
                  <i class="ri-mail-fill"></i>
               </div>
			   
			   <div class="register__box">
				  <input type="tel" name="number" pattern="[0-9]{3}-[0-9]{7}" placeholder="Enter Visitor's Phone Number*" class="register__input" required/>
                  <i class="ri-phone-line"></i>
               </div>
			   
			   <div class="register__box">
				   <input type="date" id="visitDate" name="visitDate" class="register__input"  required>
               </div>
			   
			   <div class="register__box">
				  <input type="text" id="visitPurpose" name="visitPurpose" class="register__input" placeholder="Meeting, Delivery, etc." required>
				  <i class="ri-home-4-fill"></i>
               </div>
			   
			   <div class="register__box">
				   <input class="register__input" type="text" id="residentName" name="residentName" placeholder="Resident Name" required>
				   <i class="ri-team-line"></i>
               </div>
			  

			    <div class="register__box">
				<select class="register__input" id="residentUnit" placeholder="Resident Unit" name="residentUnit" required>
					<option value="A-1">A-1</option>
					<option value="A-2">A-2</option>
					<option value="A-3">A-3</option>
					<option value="A-4">A-4</option>
					<option value="A-5">A-5</option>
					<option value="A-6">A-6</option>
					</select>
				</div>
			   

            </div>
            <button type="submit" name="btnSubmit" class="register__button">Register <i class="ri-registered-line"></i></button> 
			<a href="ManageVisitorRegistration.php" class="cancelBtn">Cancel <i class="ri-close-circle-fill"></i></a>
         </form>
      </div>
				
      </main>
      <!-- End Main -->

    </div>
  </body>
</html>