<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        

body {
    font-family: Jost, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    width: 80%;
    margin: 100px auto 50px auto; /* Updated margin-top to 100px */
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

form {
    display: flex;
    flex-direction: column;
    max-width: 300px;
    margin: 0 auto;
}

label {
    margin-bottom: 5px;
}

input[type="text"],
input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

input[type="submit"] {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 5px;
    background-color: #ee1c47;;
    color: white;
    font-weight: bold;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #ee1c47;;
}

    </style>
</head>
<body>
    <div class="container">
        <?php
        session_start();
        include 'header1.php';

        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];

            $servername = "localhost";
            $username = "root";
            $db_password = "";
            $database = "e-commerce";

            $connect = mysqli_connect($servername, $username, $db_password, $database);

            if (!$connect) {
                die("Connection Failed:" . mysqli_connect_error());
            }

            $getUserQuery = "SELECT * FROM signup WHERE id='$userId'";
            $result = mysqli_query($connect, $getUserQuery);

            if (mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);
            }
            ?>
            <form action="updatep.php" method="post">
                <label for="fname">First Name:</label>
                <input type="text" id="fname" name="fname" value="<?php echo $user['fname']; ?>"><br><br>

                <label for="lname">Last Name:</label>
                <input type="text" id="lname" name="lname" value="<?php echo $user['lname']; ?>"><br><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>"><br><br>

                <label for="phoneno">Phone Number:</label>
                <input type="text" id="phoneno" name="phoneno" value="<?php echo $user['phoneno']; ?>"><br><br>

                <input type="submit" value="Update">
            </form>
            <?php
            mysqli_close($connect);
        } else {
            echo "User ID not provided or user not logged in.";
        }
        ?>
    </div>
</body>
</html>
