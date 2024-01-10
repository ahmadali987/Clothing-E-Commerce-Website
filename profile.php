<?php
// PHP code for profile.php

session_start();

// Ensure the user is logged in and the user ID is available in the session
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Perform database connection
    $servername = "localhost";
    $username = "root";
    $db_password = "";
    $database = "e-commerce";

    $connect = mysqli_connect($servername, $username, $db_password, $database);

    if (!$connect) {
        die("Connection Failed:" . mysqli_connect_error());
    }

    // Fetch user details from the database using the user ID from the session
    $getUserQuery = "SELECT * FROM signup WHERE id='$userId'";
    $result = mysqli_query($connect, $getUserQuery);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Display user information
        echo '<!DOCTYPE html>
              <html lang="en">
              <head>
                  <meta charset="UTF-8">
                  <meta name="viewport" content="width=device-width, initial-scale=1.0">
                  <title>User Profile</title>
                  <style>
                  body {
                    font-family: Jost, sans-serif;
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                    scroll-behavior: smooth;
                    list-style: none;
                    text-decoration: none;
                    color: black;
                    background-color: #f4f4f4;
                }
                
                .container {
                    width: 80%;
                    margin: 100px auto 50px auto; /* Updated margin-top to 100px */
                    padding: 20px;
                    background-color: #fff;
                    border-radius: 8px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }
                
                h1 {
                    font-size: 24px;
                    margin-bottom: 10px;
                    color: #111; /* Adjusted color */
                }
                
                p {
                    font-size: 16px;
                    margin-bottom: 8px;
                    color: #111; /* Adjusted color */
                }
                
                .user-details {
                    background-color: #fff;
                    border-radius: 8px;
                    padding: 20px;
                    margin-bottom: 20px;
                }

                /* CSS for the form and submit button */


input[type="submit"] {
    padding: 10px 20px;
    margin-top: 10px;
    background-color: #ee1c47;;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #ee1c47;;
}
                
</style>

              </head>
              <body>';
        include 'header1.php';
        echo '<div class="container">
                      <div class="user-details">
                          <h1>User Details</h1>
                          <p>Name: ' . $user['fname'] . ' ' . $user['lname'] . '</p>
                          <p>Email: ' . $user['email'] . '</p>
                          <p>Phone: ' . $user['phoneno'] . '</p>
                          <p>Phone: ' . $user['password'] . '</p>

                          <form action="updateprofile.php" method="post">
                          <input type="hidden" name="user_id" value="' . $userId . '">
                          <input type="submit" value="Change Information">
                      </form>
                      </div>
                  </div>
              </body>
              </html>';
    } else {
        echo "User not found.";
    }

    mysqli_close($connect);
} else {
    echo "User ID not provided or user not logged in.";
}
?>
