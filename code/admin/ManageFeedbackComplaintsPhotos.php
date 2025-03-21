<?php
include("data_connection.php");

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    // Perform the deletion
    $delete_query = "DELETE FROM `feedback` WHERE feedback_id = $delete_id";
    $delete_result = mysqli_query($connect, $delete_query);

    // Check if the deletion was successful
    if ($delete_result) {

        header("Location: ManageFeedbackComplaintsPhotos.php");
        exit();
    } else {
        echo "Error deleting item.";
    }
}

// Fetch data from the feedback table
$result = mysqli_query($connect, "SELECT * FROM `feedback`");

?>

<!DOCTYPE html>
<html lang="en">
 <head>
    <title>Manage Feedback Complaints And Photos</title>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">
	<link rel="stylesheet" href="css/main.css" />
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
h2{
	text-align: left;
}

.container{
	margin-top:60px;
	padding-right:80px;
	padding-left: 80px;
}

.table{
	width:100%;
	text-align:center;

}

thead{
	font-family:Comic Sans MS;
	font-size:16px;
}

tbody{
	font-family:Average;
	font-size:16px;
}

table.table tr td:last-child {
	padding-left: 10px;

}


.table-responsive {
    margin: 30px 0;
}
.table-wrapper {
	background: #fff;
	padding: 20px 25px;
	border-radius: 3px;
	min-width: 1100px;
	box-shadow: 0 1px 1px rgba(0,0,0,.05);
}

.table-title {	
	font-family:Average;    
	padding-bottom: 15px;
	background:	#073763;
	color: #fff;
	padding: 12px 30px;
	min-width: 100%;
	border-radius: 3px 3px 0 0;
}

.table-title h2 {
	margin: 5px 0 0;
	font-size: 30px;
}

.table-title a {
	float:right;
}


table.table tr th, table.table tr td {
	border-color: #e9e9e9;
	padding: 15px 20px;
	vertical-align: middle;
}


/* update */
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
   width: 40rem;
   border-radius: .5rem;
   background-color: white;
   text-align: center;
   padding:2rem;
}

.update-container form .row{
   width: 270px;
   background-color: white;
   border-radius: .5rem;
   margin:1rem 0;
   font-size: 1.3rem;
   color:black;
   padding:1.2rem 1.4rem;
   text-transform: none;
   font-family:Average;
}


.ri-edit-box-fill, .ri-delete-bin-fill{
	font-size:23px;
}

.ri-delete-bin-fill{
	color:red;
	pointer:cursor;
}

.ri-edit-box-fill{
	color:orange;
	pointer:cursor;
}

.Deletebtn{
	color:red;
	font-size:16px;
	width:90px;
	padding-top:5px;
	padding-bottom:5px;
	border: none;
    outline: none;
	background-color: white;
}


.Deletebtn:hover{
	color:#E06666;
}



/* edit */
.edit-container, .message-container {
   position: fixed;
   top: 0;
   left: 0;
   z-index: 1100;
   background-color: transparent;
   padding: 2rem;
   display: none;
   align-items: center;
   justify-content: center;
   min-height: 100vh;
   width: 100%;
}

.edit-container form{
   max-width: 40rem; 
   width: 100%; 
   border-radius: 0.5rem;
   background-color: white;
   text-align: center;
   padding: 2rem;
   margin: auto;
   overflow-y: auto; /* Add this property to make the container scrollable */
   max-height: 90vh; /* Set a max height if needed */
}

.message-container form {
   max-width: 80rem; 
   width: 100%; 
   border-radius: 0.5rem;
   background-color: white;
   text-align: center;
   padding: 2rem;
   margin: auto;
   overflow-y: auto; /* Add this property to make the container scrollable */
   max-height: 90vh; /* Set a max height if needed */
}

.edit-container form .row, message-container form .row{
   width: 100%; 
   max-width: 50rem;
   background-color: white;
   border-radius: 0.5rem;
   margin: 1rem auto; 
   font-size: 18px;
   color: black;
   padding: .8rem 1rem;
   text-transform: none;
   font-family: Average;
   border:1px solid black;
}

.left-align {
    display: block;
    text-align: left;
	font-family: Average;
	color:black;
}

.button,.option-button{
   display: block;
   width: 100%;
   text-align: center;
   background-color: #2E8B57;
   color:white;
   font-size: 1.2rem;
   padding:.8rem 2rem;
   border-radius: 0.5rem;
   cursor: pointer;
   margin-top: 1rem;
   text-decoration: none;
}

.option-button{
	width: 50%;
	background-color:#FF0000;
}

.button:hover{
   background-color: #93C47D;
}

.option-button:hover{
	background-color:#E06666;
}

.drop-down{
	width:90px;
	height:30px;
	font-size:15px;
	font-family: Average;
}

.messageBtn{
	color:black;
	font-size: 16px;
    border: 1px solid yellow; 
    padding: 8px 12px; 
    border-radius: 4px; 
    text-decoration: none; 
	background-color:yellow;
}

.filter-buttons button {
  background-color: #666666;
  border: none;
  color: #fff;
  padding: 10px 20px;
  margin: 5px;
  cursor: pointer;
  font-size: 18px;
  border-radius: 5px;
}

.filter-buttons button:hover {
  background-color: #999999;
}

</style>
 </head>
  <body>
    <div class="grid-container">

      <!-- Sidebar -->
       <?php include 'sidebar.php'; ?>


	  <!-- Main -->
<main id="main">

  <!-- Page Title -->
  <div class="container">
    <div class="table-title">
      <h2>Manage Feedback/Complaints/Photos</h2>
    </div>
    <div class="table-wrapper">
	<div class="filter-buttons">
	  <button onclick="resetFilter()">All</button>
      <button onclick="filterFeedbacks()">Feedbacks</button>
      <button onclick="filterComplaints()">Complaints</button>
    </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Type</th>
              <th>Details</th>
              <th>Photo</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
		  
            <?php
 

            // Fetch data from the feedback table
            $result = mysqli_query($connect, "SELECT * FROM `feedback`");

            // Loop through the fetched data and display it in the table
            while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['feedback_id'] . "</td>";
            echo "<td>" . $row['feedback_name'] . "</td>";
            echo "<td>" . $row['feedback_email'] . "</td>";
            echo "<td>" . $row['feedback_type'] . "</td>";
            echo "<td>" . $row['feedback_details'] . "</td>";
            echo "<td><img src='image/" . $row['photo_upload'] . "' width='100'></td>";
            echo "<td>";
            echo "<i class='ri-delete-bin-fill'></i><a href='ManageFeedbackComplaintsPhotos.php?delete=" . $row['feedback_id'] . "' class='Deletebtn' onclick='return confirm(\"Are You Sure You Want To Delete This Feedback/Complaint?\");'>Delete</a>";
            echo "</td>";
            echo "</tr>";
            }

            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>

<script>
  // Function to filter by Feedbacks
  function filterFeedbacks() {
    filterByType("Feedback");
  }

  // Function to filter by Complaints
  function filterComplaints() {
    filterByType("Complaint");
  }

  // Function to reset the filter
  function resetFilter() {
    showAll();
  }

  // Function to filter by feedback type
  function filterByType(type) {
    const rows = document.querySelectorAll('.table tbody tr');

    rows.forEach(row => {
      const feedbackType = row.querySelector('td:nth-child(4)').innerText.toLowerCase();

      if (feedbackType === type.toLowerCase()) {
        row.style.display = 'table-row';
      } else {
        row.style.display = 'none';
      }
    });
  }

  // Function to show all rows
  function showAll() {
    const rows = document.querySelectorAll('.table tbody tr');
    rows.forEach(row => {
      row.style.display = 'table-row';
    });
  }

</script>

</body>
</html>



    </div>
  </body>
</html>