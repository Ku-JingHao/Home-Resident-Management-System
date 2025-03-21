<?php
    require_once "data_connection.php";

    $json = array();
    $sqlQuery = "SELECT * FROM event ORDER BY id";

    $result = mysqli_query($connect, $sqlQuery);
    $eventArray = array();
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($eventArray, $row);
    }
    mysqli_free_result($result);

    mysqli_close($connect);
    echo json_encode($eventArray);
?>