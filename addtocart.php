<?php
session_start();


if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

$servername = "localhost";
$username = "root";
$dbname = "e-commerce";
$db_password = "";

$conn = mysqli_connect($servername, $username, $db_password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['productId'])) {
    $productId = $_POST['productId'];

    $sql = "SELECT * FROM addtocart WHERE id = $productId";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $item = array(
            'title' => $row['title'],
            'price' => $row['price'],
            'image' => $row['image_url'],
            'id' => $row['id'], 
            'quantity' => 1 
        );

        
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        
        $existingItem = array_filter($_SESSION['cart'], function ($cartItem) use ($productId) {
            return $cartItem['id'] === $productId;
        });

        if (empty($existingItem)) {
            $_SESSION['cart'][] = $item; // Add the item to the cart session
        } else {
            // Increase quantity if the item already exists in the cart
            foreach ($_SESSION['cart'] as &$cartItem) {
                if ($cartItem['id'] === $productId) {
                    $cartItem['quantity']++;
                    break;
                }
            }
            unset($cartItem); 
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add To Cart</title>
    <link rel="stylesheet" href="addtocart.css">

    <script src="app.js">    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="">
    
    <div class="container">
        <header>
            <div class="title">Product <span>List</span></div>
            <div class="icon-cart">
    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 15a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0h8m-8 0-1-4m9 4a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-9-4h10l2-7H3m2 7L3 4m0 0-.792-3H1"/>
    </svg>
    <span>
        <!-- This is where the count should be displayed -->
        <?php
        $cartCount = 0;
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $cartItem) {
                $cartCount += $cartItem['quantity'];
            }
            echo $cartCount; // Display the cart count here
        } else {
            echo '0'; // Display '0' if the cart is empty
        }
        ?>
    </span>
</div>

        </header>
        
        <div class="listProduct">
            <?php

            $servername = "localhost";
            $username = "root"; 
            $dbname = "e-commerce";
            $db_password = "";

            $conn = mysqli_connect($servername, $username, $db_password, $dbname);
           
            
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            
            $sql = "SELECT * FROM addtocart";
            $result = mysqli_query($conn,$sql);

            if (mysqli_num_rows($result) > 0) {
                
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='product'>";
                    echo "<div class='product-image'><img src='" . $row["image"] . "' alt='" . $row["title"] . "' /></div>";
                    echo "<h3>" . $row["title"] . "</h3>";
                    echo "<p>Price: $" . $row["price"] . "</p>";
                    echo "<form action='cart_display.php' method='post'>";
                    echo "<input type='hidden' name='productId' value='" . $row["id"] . "' />";
                    echo "<button class='add-to-cart' type='submit'>ADD TO CART</button>";
                    echo "</form>";

                    echo "</div>";
                }
            } else {
                echo "0 results";
            }

            $conn->close();
            ?>
        </div>
    </div>
    
    <div class="cartTab">
    <h1>Shopping Cart</h1>
    <div class="listCart">
    <?php
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            echo "<div class='cart-item'>";
            echo "<div>" . $item['title'] . " - Quantity: " . $item['quantity'] . "</div>";
            echo "</div>";
        }
    } else {
        echo "<p>No items in the cart</p>";
    }
    ?>
</div>
    <div class="btn">
        <button class="close">CLOSE</button>
        <button class="checkOut" onclick="redirectToCheckout()">Check Out</button>
    </div>
    </div>

    
    <script>
    function redirectToCheckout() {
        // Redirect to abc.php
        window.location.href = 'cart_display.php';
    }
    </script>

</body>
</html>