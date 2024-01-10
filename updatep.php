<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servername = "localhost";
        $username = "root";
        $db_password = "";
        $database = "e-commerce";

        $connect = mysqli_connect($servername, $username, $db_password, $database);

        if (!$connect) {
            die("Connection Failed:" . mysqli_connect_error());
        }

        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $phoneno = $_POST['phoneno'];

        $updateUserQuery = "UPDATE signup SET fname='$fname', lname='$lname', email='$email', phoneno='$phoneno' WHERE id='$userId'";

        if (mysqli_query($connect, $updateUserQuery)) {
            header('location: profile.php');
        } else {
            echo "Error updating record: " . mysqli_error($connect);
        }

        mysqli_close($connect);
    } else {
        echo "Invalid request method";
    }
} else {
    echo "User ID not provided or user not logged in.";
}
?>
