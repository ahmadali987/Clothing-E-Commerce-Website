<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $cartItems = $_SESSION['cart'];

    $servername = "localhost";
    $username = "root";
    $db_password = "";
    $dbname = "e-commerce";

    $conn = mysqli_connect($servername, $username, $db_password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $user_id = $_SESSION['user_id'];

    foreach ($cartItems as $item) {
        $product_id = $item['id'];
        $title = $item['title'];
        $price = $item['price'];
        $image = $item['image'];
        $quantity = $item['quantity'];

        $check_sql = "SELECT * FROM signup s
                      INNER JOIN addtocart a ON s.id = a.user_id 
                      WHERE s.id = '$user_id' AND a.id = '$product_id'";
        $check_result = mysqli_query($conn, $check_sql);

        if (mysqli_num_rows($check_result) == 0) {
            $sql = "INSERT INTO cart (user_id, product_id, title, price, image_url, quantity) 
                    VALUES ('$user_id', '$product_id', '$title', '$price', '$image', '$quantity')";

            if (mysqli_query($conn, $sql)) {
                echo "Data inserted into cart table successfully.";
            } else {
                echo "Error inserting data into cart table: " . mysqli_error($conn);
            }
        } else {
            echo "Data already exists in cart table.";
        }
    }

   
    mysqli_close($conn);
} else {
    echo "No items in the cart to save.";
}
?>