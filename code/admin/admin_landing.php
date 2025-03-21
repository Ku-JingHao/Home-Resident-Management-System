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

?>

<!DOCTYPE html>
<html lang="en">
 <head>
    <title>Admin Dashboard</title>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">
	<link rel="stylesheet" href="css/styles.css">
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

.text-secondary {
  color: rgb(70, 71, 81);
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

/* ---------- HEADER ---------- */

.header {
  grid-area: header;
  height: 70px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 30px 0 30px;
  box-shadow: 0 6px 7px -4px rgba(0, 0, 0, 0.2);
}

.menu-icon {
  display: none;
}

/* ---------- SIDEBAR ---------- */

#sidebar {
  grid-area: sidebar;
  height: 100%;
  background-color: #674EA7;
  color: rgb(255, 255, 255);
  overflow-y: auto;

  font-family:Average;
}

.sidebar-title {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 20px 20px 20px;
  margin-bottom: 30px;
}

.sidebar-title > span {
  display: none;
}

.sidebar-brand {
  margin-top: 15px;
  font-size: 30px;
  font-weight: 700;
}

.sidebar-list {
  padding: 0;
  margin-top: 15px;
  list-style-type: none;
  color:white;
}

.sidebar-list-item {
  padding: 20px 20px 20px 20px;
  font-size: 18px;
}

.sidebar-list-item:hover {
  background-color: rgba(255, 255, 255, 0.2);
  cursor: pointer;
}

.sidebar-list-item > a {
  text-decoration: none;
  color:#D9D2E9;
}

.sidebar-responsive {
  display: inline !important;
  position: absolute;
}

/* ---------- MAIN ---------- */

.main-container {
  grid-area: main;
  overflow-y: auto;
  padding: 20px 20px;
}

.main-title {
  display: flex;
  justify-content: space-between;
  font-family:Average;
  color:white;
}

.main-cards {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr 1fr;
  gap: 20px;
  margin: 20px 0;
}

.card {
  display: flex;
  flex-direction: column;
  justify-content: space-around;
  padding: 25px;
  color: rgb(255, 255, 255);
  border-radius: 30px;
  box-shadow: 0 6px 7px -4px rgba(0, 0, 0, 0.2);
  font-family:"Times New Roman";
}

.card:first-child {
  background-color: rgb(213, 0, 0);
}

.card:nth-child(2) {
  background-color: rgb(255, 111, 0);
}

.card:nth-child(3) {
  background-color: #134F5C;
}

.card:nth-child(4) {
  background-color: rgb(29, 38, 154);
}

.card-inner {
  display: flex;
  align-items: center;
  justify-content: space-between;
  
}

.card-inner > span {
  font-size: 50px;
}

.products {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
  font-family:Average;
}

.product-card, .product-card2{
  height: 350px;
  background-color: rgb(255, 255, 255);
  padding: 25px;
  border-radius: 30px;
  box-shadow: 0 6px 7px -4px rgba(0, 0, 0, 0.2);
}

.product-card2{
	background-color:black; 
	color:white;
}

.product-description {
  padding-top: 30px;
  font-size:40px;
}

.product-button {
  background-color: rgb(29, 38, 154);
  color: rgb(255, 255, 255);
  padding: 20px;
  border-radius: 30px;
}


.social-media {
  height: 350px;
  padding: 10px;
}

.product {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}

.product-icon {
  color: rgb(255, 255, 255);
  width: 48px;
  height: 48px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 20px;
}

.product-icon > .bi {
  font-size: 25px;
}

.ri-dashboard-2-fill, .ri-user-settings-fill, .ri-user-2-fill, .ri-feedback-fill, .ri-folder-keyhole-fill, .ri-service-fill
{
	font-family:Average;
	font-size:33px;
}

.ri-group-fill, .ri-team-fill, .ri-calendar-event-fill, .ri-key-2-fill, .ri-folder-chart-fill
{
	font-size:35px;
}

.ri-notification-badge-fill, .ri-mail-unread-line, .ri-account-box-fill
{
	font-size:30px;
	color:white;
	padding-left:15px;
}

.ri-logout-box-fill
{
	font-size:25px;
	color:white;
}

.report-card a{
	text-decoration:none;
	color:white;
	font-size:23px;
}

.header-right a{
	pointer:cursor;
	text-decoration:none;
	font-size:25px;
	color:white;
	font-family:Average;
}

.header-right:hover a{
	color:red;
}


</style>
 </head>
  <body>
 
    <div class="grid-container">

      <!-- Header -->
      <header class="header">
    
        <div class="header-left">
          <a href="admin_profile.php"><i class="ri-account-box-fill"></i></a>
        </div>
        <div class="header-right">
          <i class="ri-logout-box-fill"></i><a href="admin_logout.php" onclick="return confirm('Logout From This Website?');">Log Out</a>
        </div>
      </header>
      <!-- End Header -->

      <!-- Sidebar -->
       <?php include 'sidebar.php'; ?>


      <!-- Main -->
      <main class="main-container">
        <div class="main-title">
          <h2>Admin Management System</h2>
        </div>

        <div class="main-cards">
		<?php
		 $select_resident = mysqli_query($connect, "SELECT * FROM `resident`");
		 $resident_row_count = mysqli_num_rows($select_resident);
		?>
          <div class="card">
            <div class="card-inner">
              <h2>RESIDENTS</h2>
              <i class="ri-group-fill"></i>
            </div>
            <h1><?php echo $resident_row_count; ?></h1>
          </div>
		
          <div class="card">
		  <?php
			$select_visitor = mysqli_query($connect, "SELECT * FROM `visitor`");
			$visitor_row_count = mysqli_num_rows($select_visitor);
			?>
            <div class="card-inner">
              <h2>VISITORS</h2>
              <i class="ri-team-fill"></i>
            </div>
            <h1><?php echo $visitor_row_count; ?></h1>
          </div>

          <div class="card">
		  <?php
			$select_event = mysqli_query($connect, "SELECT * FROM `event`");
			$event_row_count = mysqli_num_rows($select_event);
		?>
            <div class="card-inner">
              <h2>UPCOMING EVENTS</h2>
              <i class="ri-calendar-event-fill"></i>
            </div>
            <h1><?php echo $event_row_count; ?></h1>
          </div>

          <div class="card">
		  <?php
			$select_keyRegistration = mysqli_query($connect, "SELECT * FROM `keyregistration` WHERE keyRegistration_status = 'Activate'");
			$key_row_count = mysqli_num_rows($select_keyRegistration);
		  ?>
            <div class="card-inner">
              <h2>KEY REGISTRATION</h2>
              <i class="ri-key-2-fill"></i></i>
            </div>
            <h1><?php echo $key_row_count; ?></h1>
          </div>

        </div>

        <div class="products">

          <div class="product-card">
		  <?php
			$result = mysqli_query($connect, "SELECT title FROM event WHERE start >= CURDATE() ORDER BY start ASC LIMIT 1");

			if(mysqli_num_rows($result) > 0) {
				$row = mysqli_fetch_assoc($result);
				$latest_event_title = $row['title'];
			} else {
				$latest_event_title = "No events currently active";
			}
			?>
            <h2 class="product-description">Latest Events</h2>
            <p class="text-secondary" style="font-size:30px; margin-top:50px;">
              <?php echo $latest_event_title; ?>
            </p>
          </div>

        <div class="product-card2">
            <h2 class="product-description">Reports</h2>
            <p class="text-secondary" style="color:white; font-size:20px;">
              View Reports <i class="ri-arrow-down-fill"></i>
            </p>
			<li class="report-card">
              <i class="ri-folder-chart-fill"></i><a href="#"> Generate Report</a>
            </a>
          </li>
          </div>

        </div>
      </main>
      <!-- End Main -->

    </div>
  </body>
</html>