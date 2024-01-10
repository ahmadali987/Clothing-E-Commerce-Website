<?php
session_start();

if (isset($_POST['productId'])) {
    $productId = $_POST['productId'];

    // Connect to your database
    $servername = "localhost";
    $username = "root";
    $password = ""; // Your database password if any
    $dbname = "e-commerce";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch product details from the 'addtocart' table using the received productId
    $sql = "SELECT * FROM addtocart WHERE id = $productId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Create a new cart item with the fetched product details
        $item = array(
            'title' => $row['title'],
            'price' => $row['price'],
            'image' => $row['image_url'],
            'id' => $row['id'],
            'quantity' => 1
        );

        // Check if the session cart exists, if not, create a new one
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        // Check if the item already exists in the cart
        $existingItem = array_filter($_SESSION['cart'], function ($cartItem) use ($productId) {
            return $cartItem['id'] === $productId;
        });

        // Add the item to the cart or increase the quantity if it already exists
        if (empty($existingItem)) {
            $_SESSION['cart'][] = $item; // Add the item to the cart session
        } else {
            foreach ($_SESSION['cart'] as &$cartItem) {
                if ($cartItem['id'] === $productId) {
                    $cartItem['quantity']++;
                    break;
                }
            }
            unset($cartItem);
        }

        // Echo the updated cart content to be received by the XMLHttpRequest
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $cartItem) {
                echo "<div class='cart-item'>";
                echo "<div class='cart-item-image'><img src='" . $cartItem['image'] . "' alt='" . $cartItem['title'] . "' /></div>";
                echo "<h3>" . $cartItem['title'] . "</h3>";
                echo "<p>Price: $" . $cartItem['price'] . "</p>";
                echo "<p>Quantity: " . $cartItem['quantity'] . "</p>";
                echo "</div>";
            }
        } else {
            echo "Your cart is empty";
        }
    } else {
        echo "Product not found";
    }

    $conn->close(); // Close the database connection
} else {
    echo "Error: Product ID not received.";
}
?>
