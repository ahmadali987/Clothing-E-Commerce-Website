<?php
session_start();
$cartCount = 0;
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $cartItem) {
        $cartCount += $cartItem['quantity'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Website</title>
    <link rel="stylesheet" href="addtocart.css">

    <script src="app.js">    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">

    
    <style>
         *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    scroll-behavior: smooth;
    font-family: 'Jost', sans-serif;
    list-style: none;
    text-decoration: none;
    color: black;
}

header{
    position: fixed;
    width: 100%;
    top: 0;
    right: 0;
    z-index: 100;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 10%;
}

.logo img{
    max-width: 120px;
    height: auto;
}

.nav-menu{
    display: flex;
}

.nav-menu a {
   color: #2c2c2c;
   font-size: 16px;
   text-transform: capitalize;
   padding: 20px 20px;
   font-weight: 400;
   transition: all .42s ease;
}

.nav-menu a:hover{
    color: #ee1c47;
}

.nav-icon{
    display: flex;
    align-items: center;
}

.nav-icon i{
    margin-right: 20px;
    font-size: 25px;
    font-weight: 400;
    color: #2c2c2c;
    transition: all .42s ease;
}

.nav-icon i:hover{
    transform: scale(1.1);
    color: #ee1c47;
}

#menu-icon{
    font-size: 35px;
    color: #ee1c47;
    z-index: 101;
    cursor: pointer;
}

@media(max-width:915px){
    .cart img{
        width: 600px;
        /* align-content: center; */
        text-align: center;
    }
}

@media (max-width:630px) {
    .main-text h1{
        font-size: 50px;
        transition: .4s;
    }

    .main-text p{
        font-size: 18px;
        transition: .4s;
    }

    .main-btn{
        padding: 10px 20px;
        transition: .4s;
    }
}
        /* Additional style for cart count */
        .cart-count {
            position: relative;
            top: 8px;
            right: 8px;
            background-color: red;
            color: white;
            font-size: 12px;
            padding: 4px;
            border-radius: 50%;
            min-width: 16px;
            text-align: center;
        }
    </style>

<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet"
    href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

    <script src="script.js"></script>

</head>
<body>
    <header class="sticky">
    <a href="#" class="logo"><img src="logo.png" alt=""></a>
        
        <ul class="nav-menu">
        <li><a href="#">Home</a></li>
        <li><a href="#">Shop</a></li>
        <li><a href="#">Products</a></li>
        <!-- <li><a href="#">Page</a></li>
        <li><a href="#">Docs</a></li> -->
        </ul>

        <div class="nav-icon">
            <!-- Search and user icons -->
            <a href="#"><i class="bx bx-search"></i></a>
            <a href="#"><i class="bx bx-user"></i></a>
            
            <!-- Cart icon with cart count -->
            <a href="addtocart.php" style="position: relative;">
                <i class="bx bx-cart"></i>
                <?php if ($cartCount > 0) : ?>
                    <span class="cart-count"><?php echo $cartCount; ?></span>
                <?php endif; ?>
            </a>

            
            <a href="#"><i class='bx bx-menu' id="menu-icon"></i></a>
        </div>
    </header>

</body>
</html>
