<?php
include("data_connection.php");

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};

if (isset($_POST['btnSubmit'])) {
    $visitorType = $_POST['visitorType'];
    $visitorType = filter_var($visitorType, FILTER_SANITIZE_STRING);
    $visitorName = $_POST['visitorName'];
    $visitorName = filter_var($visitorName, FILTER_SANITIZE_STRING);
    $visitorEmail = $_POST['visitorEmail'];
    $visitorEmail = filter_var($visitorEmail, FILTER_SANITIZE_STRING);
	    // Validate email format
    if (!filter_var($visitorEmail, FILTER_VALIDATE_EMAIL)) {
        $message[] = 'Invalid email format';
    } else {

    $visitorNumber = $_POST['visitorNumber'];
    $visitorNumber = filter_var($visitorNumber, FILTER_SANITIZE_STRING);
    $visitDate = $_POST['visitDate'];
    $visitDate = filter_var($visitDate, FILTER_SANITIZE_STRING);
    $visitPurpose = $_POST['visitPurpose'];
    $visitPurpose = filter_var($visitPurpose, FILTER_SANITIZE_STRING);
    $residentName = $_POST['residentName'];
    $residentName = filter_var($residentName, FILTER_SANITIZE_STRING);
    $residentUnit = $_POST['residentUnit'];
    $residentUnit = filter_var($residentUnit, FILTER_SANITIZE_STRING);

    $insert_query = mysqli_query($connect, "INSERT INTO `visitor` (visitor_type, visitor_name, visitor_email, visitor_number, visit_date, visit_purpose, resident_name, resident_unit)
            VALUES ('$visitorType', '$visitorName', '$visitorEmail', '$visitorNumber', '$visitDate', '$visitPurpose', '$residentName', '$residentUnit')");

    if ($insert_query) {
        echo "Inserted Successfully";
        header("Location: success_page.php"); // Redirect to a success page
        exit(); // Ensure that no further content is sent
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate QR Code for Visitors</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">
    <link rel="stylesheet" href="css/resident_main.css" />

    <style>
	
	<?php include'css/resident_main.css';?>
	
	
	
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');
        * {
            box-sizing: border-box;
            padding: 0;
            margin: 0;
        }

        body {
            width: 100%;
            height: 100%;
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

        /*end body*/
		
        .qrcode {
        display: flex;
        align-items: center;
        justify-content: center;
		font-family:Average;
        }

        .form-qrcode {
        background-color: #fff;
        border-radius: 30px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);
        overflow: hidden;
        width: 680px;
        max-width: 100%;
        padding: 40px;
        box-sizing: border-box;
        text-align: left; /* Center text inside the form */
        }

        .qrcode p {
            font-size: 14px;
            line-height: 20px;
            letter-spacing: 0.3px;
            margin: 20px 0;
        }

        .qrcode span {
            font-size: 12px;
        }

        .qrcode a {
            color: #333;
            font-size: 13px;
            text-decoration: none;
            margin: 15px 0 10px;
        }

        .qrcode button {
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

        .qrcode button.hidden {
            background-color: transparent;
            border-color: #fff;
        }

        .qrcode form {
            background-color: #fff;
            display: flex;
            align-items: left;
            justify-content: center;
            flex-direction: column;
            padding: 0 40px;
            height: 100%;
            box-sizing: border-box;
        }

h1 {
        font-family: Average;
}

    .toggle-panel.toggle-right p,
    .toggle-panel.toggle-left p {
    font-size: 16px;
    text-align: left;
    font-family: Average;
}

.qrcode span {
     font-family: Average;
     font-size: 15px;
     text-align: left;
}
		
#qrcode label {
    display: block;
    margin-bottom: 5px;
}

#qrcode input, #qrcode select, #qrcode textarea {
    width: 100%;
    padding: 8px; /* Add padding to input, select, and textarea elements */
    margin-bottom: 10px;
    box-sizing: border-box; /* Include padding and border in element's total width and height */
}

#qrCodeDisplay {
     margin:auto; 
}

select option, .select_option{
	font-family: Average;
	font-size: 16px;
}
    </style>
</head>
<body>
    <div class="landing">
	<?php include 'header.php'; ?>
		
       
        <div class="qrcode" id="qrcode">
        
            <div class="form-qrcode sign-in">
                <form id="qrCodeForm" method="post" action="" enctype="multipart/form-data">
                    <h1 style="margin-bottom:10px;">Generate QR Code for Visitors <i class="ri-qr-code-fill"></i></h1>
                    <label for="visitorType">Visitor Type:</label>
                    <select id="visitorType" class="select_option" name="visitorType" required>
                        <option value="Registered">Registered</option>
                        <option value="Scheduled">Scheduled</option>
                    </select>

                    <label for="visitorName">Visitor Name:</label>
                    <input type="text" id="visitorName" name="visitorName" placeholder="Cai Xu Kun" required>

                    <label for="visitorEmail">Visitor Email:</label>
                    <input type="email" id="visitorEmail" name="visitorEmail" placeholder="caixukun1998@gmail.com" required>

                    <label for="visitorNumber">Visitor Phone Number:</label>
                    <input type="tel" id="visitorNumber" name="visitorNumber" pattern="[0-9]{3}-[0-9]{7}" placeholder="012-3456789" required>

                    <label for="visitDate">Visit Date:</label>
                    <input type="date" id="visitDate" name="visitDate" required>

                    <label for="visitPurpose">Purpose of Visit:</label>
                    <input type="text" id="visitPurpose" name="visitPurpose" placeholder="Meeting, Delivery, etc." required>

                    <label for="residentName">Resident Name:</label>
                    <input type="text" id="residentName" name="residentName" placeholder="Resident Name" required>

                    <label for="residentUnit">Resident Unit:</label>
					<select class="select_option" id="residentUnit" placeholder="Resident Unit" name="residentUnit" required>
					<option value="A-1">A-1</option>
					<option value="A-2">A-2</option>
					<option value="A-3">A-3</option>
					<option value="A-4">A-4</option>
					<option value="A-5">A-5</option>
					<option value="A-6">A-6</option>
					</select>
					
                    <label for="generateQR">Generate QR Code:</label>
                    <button type="button" name="btnSubmit" onclick="generateQR()">Generate</button>

                    <div id="qrCodeDisplay" style="margin-top: 20px;"></div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
	
       <script>
    function generateQR() {
        // Get form values
        const visitorType = document.getElementById("visitorType").value;
        const visitorName = document.getElementById("visitorName").value;
        const visitorEmail = document.getElementById("visitorEmail").value;
        const visitorNumber = document.getElementById("visitorNumber").value;
        const visitDate = document.getElementById("visitDate").value;
        const visitPurpose = document.getElementById("visitPurpose").value;
        const residentName = document.getElementById("residentName").value;
        const residentUnit = document.getElementById("residentUnit").value;

        // Validate form fields
        if (
            !visitorType ||
            !visitorName ||
            !visitorEmail ||
            !visitorNumber ||
            !visitDate ||
            !visitPurpose ||
            !residentName ||
            !residentUnit
        ) {
            alert("Please fill in all fields");
            return;
        }

        // Validate email format
        if (!isValidEmail(visitorEmail)) {
            alert("Invalid email format");
            return;
        }

        // Validate phone number format
        if (!isValidPhoneNumber(visitorNumber)) {
            alert("Invalid phone number format");
            return;
        }

        // Generate QR code
        const qrCodeValue = `Visitor Type: ${visitorType}\nVisitor: ${visitorName}\nEmail: ${visitorEmail}\nPhone: ${visitorNumber}\nVisit Date: ${visitDate}\nPurpose: ${visitPurpose}\nResident Name: ${residentName}\nResident Unit: ${residentUnit}`;

        // Remove existing QR code if any
        const existingQRCode = document.getElementById("qrCode");
        if (existingQRCode) {
            existingQRCode.parentNode.removeChild(existingQRCode);
        }

        // Create new QR code element
        const qrCodeElement = document.createElement("div");
        qrCodeElement.id = "qrCode";
        document.getElementById("qrCodeDisplay").appendChild(qrCodeElement);

        // Generate new QR code
        new QRCode(qrCodeElement, qrCodeValue);

        // Submit form data using AJAX
        $.ajax({
            type: 'POST',
            url: 'GenerateQrCode.php', // Replace with the actual PHP script file
            data: {
                visitorType: visitorType,
                visitorName: visitorName,
                visitorEmail: visitorEmail,
                visitorNumber: visitorNumber,
                visitDate: visitDate,
                visitPurpose: visitPurpose,
                residentName: residentName,
                residentUnit: residentUnit,
                btnSubmit: true
            },
            success: function (response) {
                // Handle the response (e.g., display a success message)
                console.log(response);
            },
            error: function (error) {
                // Handle errors
                console.log(error);
            }
        });
    }

    function isValidEmail(email) {
        // Use a regular expression for basic email validation
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(email);
    }

    function isValidPhoneNumber(phoneNumber) {
        // Use a regular expression for basic phone number validation
        const phonePattern = /^[0-9]{3}-[0-9]{7}$/;
        return phonePattern.test(phoneNumber);
    }
</script>
</body>
</html>