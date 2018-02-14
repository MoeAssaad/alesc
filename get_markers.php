<?php
$logementID = 1234;
$dir = "images/$logementID/vr";
// database connection
$servername = "localhost";
$username = "moe";
$password = "moudi/12";
$dbname = "mydb";
$vec = array();
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//echo "Connected successfully \n";
$sql = "SELECT * FROM `markeur` WHERE INT_logement_ID = '$logementID'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    foreach($result as $row) {
        $vec[] = $row;
    }
    echo json_encode($vec);
    //echo "success";
} else {
    echo "0 results";
}
$conn->close();
?>