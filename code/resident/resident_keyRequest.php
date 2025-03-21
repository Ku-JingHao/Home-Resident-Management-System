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

// Check if the form is submitted
if(isset($_POST['btnSubmit'])){
   $name = $_POST['name'];
   $email = $_POST['email'];
   $number = $_POST['number'];
   $residenceUnitNumber = $_POST['residenceUnitNumber'];

   // Check if the user has already submitted a request and it is not rejected
   $existingRequestQuery = mysqli_query($connect, "SELECT * FROM `key` WHERE user_id = '$user_id' AND key_Status != 'Rejected'");
   if(mysqli_num_rows($existingRequestQuery) > 0){
      $message[] = 'You have already submitted a key request. Please check the status.';
   } else {
      // Insert the new key request
      $insert_query = mysqli_query($connect, "INSERT INTO `key`(user_id, key_requestedName, key_requestedEmail, key_requestedNumber, key_unitNumber) 
      VALUES('$user_id', '$name', '$email', '$number', '$residenceUnitNumber')");

      if($insert_query) {
         $message[] = 'Key Requested Successfully!';
		// Redirect to a different page after processing the form
		$_SESSION['success_message'] = 'Key Requested Successfully!';
		header('Location:resident_keyRequest.php');
		exit();
      } else {
         $message[] = 'Error submitting key request. Please try again.';
      }
   }
}

if(isset($_GET['deleteMessage']))
{
   $delete_id = $_GET['deleteMessage'];
   $delete_users = mysqli_query($connect, "DELETE FROM `key` WHERE key_id = $delete_id");
   header("Location: resident_keyRequest.php");  
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Key Request Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">
   <link rel="stylesheet" href="css/resident_main.css" />
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
	font-family: 'Poppins', sans-serif;
	font-size: 16px;
	font-weight: normal;
	line-height: 1.5;
	width: 100%;
	overflow-x: hidden;
}


/* Ends basic desing */
.key-request{
    background-color: #fff;
    border-radius: 30px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);
    position: relative;
    overflow: hidden;
    width: 768px;
    max-width: 100%;
    min-height: 480px;
	margin-top:40px;
	margin-left:400px;
}

.key-request p{
    font-size: 14px;
    line-height: 20px;
    letter-spacing: 0.3px;
    margin: 20px 0;
}

.key-request span{
    font-size: 12px;
}

.key-request a{
    color: #333;
    font-size: 13px;
    text-decoration: none;
    margin: 15px 0 10px;
}

.key-request button{
    background-color: #f12711;
    color: #fff;
    font-size: 14px;
    padding: 10px 45px;
    border: 1px solid transparent;
    border-radius: 8px;
    font-weight: 600;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    margin-top: 10px;
    cursor: pointer;
}

.key-request button.hidden{
    background-color: transparent;
    border-color: #fff;
}

.key-request form{
    background-color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0 40px;
    height: 100%;
	 box-sizing: border-box;
}

.key-request input, .key-request select{
    background-color: #eee;
	color:grey;
    border: none;
    margin: 8px 0;
    padding: 10px 15px;
    font-size: 15px;
    border-radius: 8px;
    width: 100%;
    outline: none;
	font-family:Average;
}

.form-key-request{
    position: absolute;
    top: 0;
    height: 100%;
    transition: all 0.6s ease-in-out;
}

.sign-in{
    left: 0;
    width: 50%;
    z-index: 2;
}

.key-request.active .sign-in{
    transform: translateX(100%);
}

.sign-up{
    left: 0;
    width: 50%;
    opacity: 0;
    z-index: 1;
}

.key-request.active .sign-up{
    transform: translateX(100%);
    opacity: 1;
    z-index: 5;
    animation: move 0.6s;
}

@keyframes move{
    0%, 49.99%{
        opacity: 0;
        z-index: 1;
    }
    50%, 100%{
        opacity: 1;
        z-index: 5;
    }
}

.social-icons{
    margin: 20px 0;
}

.social-icons a{
    border: 1px solid #ccc;
    border-radius: 20%;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    margin: 0 3px;
    width: 40px;
    height: 40px;
}

.toggle-key-request{
    position: absolute;
    top: 0;
    left: 50%;
    width: 50%;
    height: 100%;
    overflow: hidden;
    transition: all 0.6s ease-in-out;
    border-radius: 150px 0 0 100px;
    z-index: 1000;
}

.key-request.active .toggle-key-request{
    transform: translateX(-100%);
    border-radius: 0 150px 100px 0;
}

.toggle{
    background-color: #f12711;
    height: 100%;
    background: linear-gradient(to right, #f12711, #f5af19);
    color: #fff;
    position: relative;
    left: -100%;
    height: 100%;
    width: 200%;
    transform: translateX(0);
    transition: all 0.6s ease-in-out;
}

.key-request.active .toggle{
    transform: translateX(50%);
}

.toggle-panel{
    position: absolute;
    width: 50%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0 30px;
    text-align: center;
    top: 0;
    transform: translateX(0);
    transition: all 0.6s ease-in-out;
}

.toggle-left{
    transform: translateX(-200%);
}

.key-request.active .toggle-left{
    transform: translateX(0);
}

.toggle-right{
    right: 0;
    transform: translateX(0);
}

.key-request.active .toggle-right{
    transform: translateX(200%);
}

h1{
	font-family:Average; 
	font-size: 30px;
}

.toggle-panel.toggle-right p, .toggle-panel.toggle-left p{
    font-size: 16px;
	text-align:left;
	font-family:Average;	
}

.key-request span {
	font-family:Average;	
    font-size: 15px;
	text-align:left;
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
	font-family:Average;
	font-size: 16px;
}

.table td, .table th {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.table th {
    background-color: #f2f2f2;
}

.table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.empty{
	font-family:Average;
}

.ri-delete-bin-fill{
	font-size:23px;
	color:red;
	pointer:cursor;
}


.Deletebtn{
	color:red;
	font-size:16px;
}

.Deletebtn:hover{
	color:#E06666;
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
	
		<section class="key">
		<div class="key-request" id="key-request">
        <div class="form-key-request sign-up">
            <form>
                <h1 style="font-size: 28px;">Key Requested Status <i class="ri-check-double-fill"></i></h1>		
               <table class="table">
				<tbody>
				<?php
					$results = mysqli_query($connect, "SELECT * FROM `key` WHERE user_id = '$user_id'");
					if(mysqli_num_rows($results) > 0){
					while($row = mysqli_fetch_assoc($results)){
				?>
					<tr>
						<td>Key Requested Name</td>
						<td><?php echo $row['key_requestedName']; ?></td>
					</tr>
					<tr>
						<td>Key Requested Email</td>
						<td><?php echo $row['key_requestedEmail']; ?></td>
					</tr>	
					<tr>
						<td>Key Requested Phone Number</td>
						<td><?php echo $row['key_requestedNumber']; ?></td>
					</tr>
					<tr>
						<td>Key Requested Date</td>
						<td><?php echo $row['key_DateRegistered']; ?></td>
					</tr>
					<tr>
						<td>Key Requested Unit</td>
						<td><?php echo $row['key_unitNumber']; ?></td>
					</tr>
					<tr>
						<td>Key Status</td>
						<td style="color:<?php if($row['key_Status'] == 'Pending'){ echo 'orange'; } else if($row['key_Status'] == 'Successfully'){ echo 'green'; } else { echo 'red'; }; ?>"><?php echo $row['key_Status']; ?></td>
					</tr>	
				<?php
                // Add the condition to display the Delete button only when status is 'Rejected'
                if($row['key_Status'] == 'Rejected'){
                ?>
                    <tr>
                        <td>Delete Request</td>
                        <td><a href="resident_keyRequest.php?deleteMessage=<?= $row['key_id']; ?>" class="Deletebtn" onclick="return confirm('Are You Sure You Want To Delete Your Previous Key Request?');"><i class="ri-delete-bin-fill"></i> Delete</a></td>
                    </tr>
                <?php
                }
						}
					} else {
						echo '<p class="empty">No Requested Key Yet!</p>';
					}
				?>
				</tbody>
			</table>
            </form>
        </div>
		
        <div class="form-key-request sign-in">
            <form action="#" method="post">
                <h1 style="margin-bottom:10px;">Key Request <i class="ri-key-2-fill"></i></h1>
				<span>Kindly be advised that you may submit a request for the key to your residence by utilizing the provided form.</span>
				<input type="text" id="FirstName" name="name" class="register__input " placeholder="Enter Your Name*"required>
                <input type="email" name="email" placeholder="Enter Your Email*" class="register__input" required>
                <input type="tel" name="number" pattern="[0-9]{3}-[0-9]{7}" placeholder="Enter Your Phone Number*" class="register__input" required>
				<select class="register__input" name="residenceUnitNumber" required>
				<option value="A-1">A-1</option>
				<option value="A-2">A-2</option>
				<option value="A-3">A-3</option>
				<option value="A-4">A-4</option>
				<option value="A-5">A-5</option>
				<option value="A-6">A-6</option>
				</select>
                <button type="submit" name="btnSubmit">Submit Request</button>
            </form>
        </div>
        <div class="toggle-key-request">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Key Request Form <i class="ri-survey-fill"></i></h1>
                    <p>Please navigate to the key request form by clicking on the provided button. In the event that your initial request is unsuccessful, we kindly ask that you submit a new request.</p>
                    <button class="hidden" id="login">Request Form</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Key Status <i class="ri-checkbox-circle-fill"></i></h1>
                    <p>Kindly inquire about the current status of your requested key by accessing the following button</p>
                    <button class="hidden" id="register">Check Status</button>
                </div>
            </div>
        </div>
    </div>

    <script>
	const container = document.getElementById('key-request');
	const registerBtn = document.getElementById('register');
	const loginBtn = document.getElementById('login');
	registerBtn.addEventListener('click', () => {
		container.classList.add("active");
	});

	loginBtn.addEventListener('click', () => {
		container.classList.remove("active");
	});
	</script>	
		</section>
	</section>

	<script src="js/script.js"></script>

</body>
</html>