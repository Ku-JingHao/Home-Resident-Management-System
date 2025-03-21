<?php
require_once "data_connection.php";

$id = $_POST['id'];
$sqlDelete = "DELETE from event WHERE id=".$id;

mysqli_query($connect, $sqlDelete);
echo mysqli_affected_rows($connect);

mysqli_close($connect);
?>