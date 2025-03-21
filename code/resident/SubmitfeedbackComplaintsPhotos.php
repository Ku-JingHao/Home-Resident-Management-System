<?php include("data_connection.php");

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if (isset($_POST['btnSubmit'])) {	
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $feedbackType = $_POST['feedbackType'];
   $feedbackType = filter_var($feedbackType, FILTER_SANITIZE_STRING);
   $feedbackDetails = $_POST['feedbackDetails'];
   $feedbackDetails = filter_var($feedbackDetails, FILTER_SANITIZE_STRING);
   $photoUpload = $_FILES['photoUpload']['name'];
   $photoUpload_tmp_name = $_FILES['photoUpload']['tmp_name'];
   $photoUpload_folder = 'C:/xampp/htdocs/SE Fundamentals Project PHP/admin/image/'.$photoUpload;

    $insert_query = mysqli_query($connect, "INSERT INTO `feedback` (feedback_name, feedback_email, feedback_type, feedback_details, photo_upload)
            VALUES ('$name', '$email', '$feedbackType', '$feedbackDetails', '$photoUpload')");

   if($insert_query){
      move_uploaded_file($photoUpload_tmp_name, $photoUpload_folder);
      $message[] = 'Submitted Succesfully';
   }else{
      $message[] = 'Could Not Be Submitted'; 
   }
};
?>

<!DOCTYPE html>
<html>
<head>
    <title>Submit Feedback Or Complaint Form</title>
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

/*end body*/
.feedback{
    background-color: #fff;
    border-radius: 30px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);
    overflow: hidden;
    width: 680px;
    max-width: 100%;
    min-height: 450px;
	margin-left:400px;
}

.feedback p{
    font-size: 14px;
    line-height: 20px;
    letter-spacing: 0.3px;
    margin: 20px 0;
}

.feedback span{
    font-size: 12px;
}

.feedback a{
    color: #333;
    font-size: 13px;
    text-decoration: none;
    margin: 15px 0 10px;
}

.feedback button{
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

.feedback button.hidden{
    background-color: transparent;
    border-color: #fff;
}

.feedback form{
    background-color: #fff;
    display: flex;
    align-items: left;
    justify-content: center;
    flex-direction: column;
    padding: 0 40px;
    height: 100%;
	box-sizing: border-box;
	font-family:Average;
	padding:15px;
	font-size:17px;
}

h1{
	font-family:Average; 
	font-size:25px;
	padding-top:15px;
	padding-bottom:10px;
}

.toggle-panel.toggle-right p, .toggle-panel.toggle-left p{
    font-size: 16px;
	text-align:left;
	font-family:Average;	
}

.feedback span {
	font-family:Average;	
    font-size: 15px;
	text-align:left;
}


#feedbackForm label {
     display: block;
     margin-bottom: 5px;
}

#feedbackForm input, #feedbackForm select, #feedbackForm textarea {
    width: 100%;
    padding: 8px; /* Add padding to input, select, and textarea elements */
    margin-bottom: 10px;
    box-sizing: border-box; /* Include padding and border in element's total width and height */
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
		
	
		<section class="submit_feedback_form">
			<div class="feedback" id="feedback">
	
        <div class="form-feedback sign-in">
            <form id="feedbackForm" method="post" action="" enctype="multipart/form-data">

                <h1 style="margin-bottom:10px;">Submit Feedback or Complaint <i class="ri-feedback-fill"></i></h1>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" placeholder="cai xu kun" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="caixukun1998@gmail.com" required>

                <label for="feedbackType">Feedback Type:</label>
                <select id="feedbackType" name="feedbackType" required>
                    <option value="feedback">Feedback</option>
                    <option value="complaint">Complaint</option>
                </select>

                <label for="feedbackDetails">Details:</label>
                <textarea id="feedbackDetails" name="feedbackDetails" rows="6" placeholder="Write your problems here!" required></textarea>

                <label for="photoUpload">Upload Photo (Optional):</label>
                <input type="file" id="photoUpload" name="photoUpload" accept="image/png, image/jpg, image/jpeg">

                <button type="submit" name="btnSubmit"  class="login__button" >Submit</button>
            </form>
        </div>
    </div>
		</section>
	</section>

	<script src="js/script.js"></script>

</body>
</html>