<?php
session_start();
?>
<?php

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
            'image' => $row['image'],
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
    header("Location: addtocart.php");
    exit;
}

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
    <style>
       /* Cart Table Styles */

       .cart-table {
    width: 90%; /* Adjust the width as needed */
    margin: 20px auto; /* Center the table horizontally */
    border-collapse: collapse;
    border-radius: 5px;
    overflow: hidden;
    background-color: #ffffff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.cart-table th,
.cart-table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

.cart-table th {
    background-color: #f2f2f2;
}

.cart-item-image img {
    max-width: 80px;
    max-height: 80px;
    border-radius: 5px;
}

/* Buttons */
.cart-table button {
    padding: 8px 12px;
    background-color: #ee1c47;
    color: white;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    overflow-x: auto; /* Add horizontal scrolling when content overflows */
    max-width: 100%; /* Ensure the container doesn't exceed the viewport width */
}

.cart-table button:hover {
    background-color: #c40026;
}

.cart-table input[type='submit'] {
    padding: 8px 12px;
    background-color: #008CBA;
    color: white;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.cart-table input[type='submit']:hover {
    background-color: #005f77;
}

.cart-table button,
.cart-table input[type='submit'] {
    padding: 8px 12px;
    min-width: 50px; /* Set minimum button width */
    height: 36px; /* Set button height */
    font-size: 14px; /* Adjust font size */
}

@media screen (min-width:550px) {
    .cart-table{
        width:80%
    }
}

    </style>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet"
    href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <script src="cart_display.js"></script>

</head>
<body>

    <header class="sticky">
        <a href="#" class="logo"><img src="logo.png" alt=""></a>
        
        <ul class="nav-menu">
        <li><a href="#">Home</a></li>
        <li><a href="#">Shop</a></li>
        <li><a href="#">Products</a></li>
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
            <a href="#"><i class="bx bx-user"></i></a>
            <a href="addtocart.php"><i class="bx bx-cart" ></i></a>

            <a href="#"><i class='bx bx-menu' id="menu-icon" ></i></a>

        </div>
    </header><br><br><br><br>

    
        <table class='cart-table'>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Action</th>
                <th>Order</th> <!-- New column for buttons -->
            </tr>

            <?php
            // Display cart items within a table
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $key => $cartItem) {
                    echo "<tr class='cart-item'>";
                    echo "<td class='cart-item-image'><img src='" . $cartItem['image'] . "' alt='" . $cartItem['title'] . "' /></td>";
                    echo "<td>" . $cartItem['title'] . "</td>";
                    echo "<td>$" . $cartItem['price'] . "</td>";
                    echo "<td>
                    <button onclick=\"updateQuantity($key, 'decrease')\">-</button><br>
                    <span id=\"quantity_$key\">" . $cartItem['quantity'] . "</span><br>
                    <button onclick=\"updateQuantity($key, 'increase')\">+</button><br>
                    </td>";

                    // Add buttons for removing and ordering
                    echo "<td>";
                    echo "<button onclick='removeItem($key)'>Remove</button>";
                    echo "</td>";

                    echo "<td>";
                    echo "<form action='order_page.php' method='post'>";
                    echo "<input type='hidden' name='productId' value='" . $cartItem['id'] . "' />";
                    echo "<input type='submit' value='Order' />";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Your cart is empty</td></tr>";
            }
            ?>

        </table>
   


</body>


</html>

<?php
$conn->close();
?>