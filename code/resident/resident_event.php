
<!DOCTYPE html>
<html>
<head>
	<title>Resident Event Page</title>
	<link rel="stylesheet" href="fullcalendar/fullcalendar.min.css" />
	<script src="fullcalendar/lib/jquery.min.js"></script>
	<script src="fullcalendar/lib/moment.min.js"></script>
	<script src="fullcalendar/fullcalendar.min.js"></script>

	<link rel="stylesheet" href="css/resident_main.css" />

  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">
  <script>

$(document).ready(function () {
    var calendar = $('#calendar').fullCalendar({
        editable: true,
        events: "fetch-event.php",
        displayEventTime: false,
        eventRender: function (event, element, view) {
            if (event.allDay === 'true') {
                event.allDay = true;
            } else {
                event.allDay = false;
            }
        },
       
        selectHelper: true,
        select: function (start, end, allDay) {
            var title = prompt('Event Title:');

            if (title) {
                var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");

               
                calendar.fullCalendar('renderEvent',
                        {
                            title: title,
                            start: start,
                            end: end,
                            allDay: allDay
                        },
                true
                        );
            }
            calendar.fullCalendar('unselect');
        },
        
        editable: true,
        eventDrop: function (event, delta) {
                    var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                    var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                    $.ajax({
                        url: 'edit-event.php',
                        data: 'title=' + event.title + '&start=' + start + '&end=' + end + '&id=' + event.id,
                        type: "POST",
                        success: function (response) {
                            displayMessage("Updated Successfully");
                        }
                    });
                },
        

    });
});

function displayMessage(message) {
	    $(".response").html("<div class='success'>"+message+"</div>");
    setInterval(function() { $(".success").fadeOut(); }, 1000);
}
</script>
  <style>
  <?php include'css/resident_main.css';?>
body {
        text-align: center;
    }

    #calendar {
        width: 80%; /* Adjust the width as a percentage of the container */
        margin: 0 auto;
        margin-top: 50px; /* Adjust the margin-top for spacing */
        max-width: 800px; /* Set a maximum width to maintain responsiveness */
		font-family:Average;
    }


    .success {
        background: #cdf3cd;
        padding: 10px 60px;
        border: #c3e6c3 1px solid;
        display: inline-block;
    }
</style>
  
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

.fc-view-container {
  background-color:  #D58A94;
  
}

h2 {
	color: #E6E6FA	;
	
}

/* Ends basic desing */
</style>
</head>
<body>	
	<section class="landing">
	<?php include 'header.php'; ?>
		<div class="response"></div>
    <div id='calendar'></div>
	<script src="js/script.js"></script>
	</section>
</body>
</html>




