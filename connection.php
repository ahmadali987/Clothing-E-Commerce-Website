<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "e-commerce";


$conn = mysqli_conec($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
