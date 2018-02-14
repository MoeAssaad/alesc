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
$sql = "SELECT * FROM `chambre` WHERE INT_logement_ID = '$logementID'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    foreach ($result as $row) {
        $vec [] = $row;
    }
    echo json_encode($vec);
        
    // while($row = $result->fetch_assoc()) {
        
    //     // $result_str = "id: " . $row["INT_chambre_ID"]. " - rotationx: " . $row["INT_rotation_x"]. " - rotationy: ". $row["INT_rotation_y"] . " - rotationz: ". $row["INT_rotation_z"] .  "<br>";
    //     // $js_array = json_encode($result_str);
    //     echo $js_array;
    // }
} else {
    echo "0 results";
}
$conn->close();
?>