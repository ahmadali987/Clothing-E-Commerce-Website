<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="login.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Jost:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
  
</head>
<body>
  <div class="wrapper">
    <h2>Login</h2>
    <form action="#" onsubmit="return validateForm()" method="post">
      <div class="input-box">
        <input type="email" id="email" name="email" placeholder="Enter your Email" required>
      </div>
      <div class="input-box">
        <input type="password" id="password" name="password" placeholder="Enter Password" required minlength="8">
        <small>Password must be at least 8 characters long.</small>
      </div>
      <div class="input-box button">
        <input type="submit" name="submit" value="Login">
      </div>
      <div class="text">
        <h3>Don't have an account? <a href="signup.php">Sign up now</a></h3>
      </div>
    </form>
  </div>

  <script>
    function validateForm() {
      const email = document.getElementById('email').value.trim();
      const password = document.getElementById('password').value.trim();

      // Email validation (simple pattern)
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailPattern.test(email)) {
        alert('Please enter a valid email address.');
        return false;
      }

      // Password length check
      if (password.length < 8) {
        alert('Password must be at least 8 characters long.');
        return false;
      }

      // If all validations pass, the form submits
      return true;
    }
  </script>
</body>
</html>

<?php
session_start();

if(isset($_POST["submit"])) {
    $servername = "localhost";
    $username = "root";
    $db_password = "";
    $database = "e-commerce";

    $email = $_POST['email'];
    $pass = $_POST['password'];

    $connect = mysqli_connect($servername, $username, $db_password, $database);

    if(!$connect) {
        die("Connection Error: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM signup WHERE email = '$email' AND password = '$pass'";
    $result = mysqli_query($connect, $sql);

    if($result) {
        if(mysqli_num_rows($result) > 0) {
            // Fetch user's ID and store it in the session
            $row = mysqli_fetch_assoc($result);
            $_SESSION['loggedin'] = true; 
            $_SESSION['email'] = $email; 
            $_SESSION['user_id'] = $row['id']; // Fetch and store user's ID
            header("Location: homepage.php");
            exit(); 
        } else {
            echo "<script>alert('Login Failed: Incorrect email or password')</script>";
        }
    } else {
        echo "Error: " . mysqli_error($connect);
    }

    mysqli_close($connect);
}


if(isset($_GET['logout'])) {
    session_unset(); 
    session_destroy(); 
    header("Location: login.php"); 
    exit();
}
?>
