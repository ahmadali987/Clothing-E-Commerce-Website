<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Website</title>

    <!-- <link rel="stylesheet" href="reset.css"> -->
    <link rel="stylesheet" href="header.css">
    <script src="script.js"></script>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet"
    href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

</head>
<body>

    <header class="sticky">
        <a href="#" class="logo"><img src="logo.png" alt=""></a>
        
        <ul class="nav-menu">
        <li><a href="homepage.php">Home</a></li>
        <li><a href="addtocart.php">Shop</a></li>
        <li><a href="addtocart.php">Products</a></li>
        <?php
            // Check if the user is logged in
            // You should replace the following condition with your actual login status check
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                echo '<li><a href="logout.php">Logout</a></li>';
            } else {
                echo '<li><a href="login.php">Login</a></li>';
            }
        ?>
        <!-- <li><a href="#">Page</a></li>
        <li><a href="#">Docs</a></li> -->
        </ul>

        <div class="nav-icon">

            <a href="#"><i class="bx bx-search"></i></a>
            <a href="profile.php<?php echo isset($_SESSION['user_id']) ? '?userId=' . $_SESSION['user_id'] : ''; ?>"><i class="bx bx-user"></i></a>
            <a href="addtocart.php"><i class="bx bx-cart" ></i></a>

            <a href="#"><i class='bx bx-menu' id="menu-icon" ></i></a>

        </div>
    </header>


<section class="main-home" >
        <div class="main-text">
            <h5>Winter Collection</h5><br>
            <h1>New Winter <br> Collection 2024 </h1><br>
            <p>There's Nothing Like Clothing Trends</p><br>

            <a href="#" class="main-btn">Show Now <box-icon class="bx bx-right-arrow-alt" ></box-icon></a>
        </div>

        <div class="down-arrow">
            <a href="#trending" class="down"><i class='bx bx-down-arrow-alt'></i></a>
        </div>
    </section>

    </body>
</html>