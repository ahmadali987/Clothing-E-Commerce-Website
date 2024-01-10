<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['index'])) {
    $index = filter_input(INPUT_GET, 'index', FILTER_VALIDATE_INT);

    if ($index !== false && isset($_SESSION['cart'][$index])) {
        // Remove the item from the cart using the provided index
        unset($_SESSION['cart'][$index]);

        // Re-index the array after removal to ensure continuous indexes
        $_SESSION['cart'] = array_values($_SESSION['cart']);

        // Redirect back to the page showing the updated cart or provide a success message
        header("Location: addtocart.php"); // Change this to your desired page
        exit;
    }
}

// If the request encounters an error or the item cannot be removed, redirect with an error message
header("Location: addtocart.php?error=1"); // Redirect with an error flag or message
exit;
?>
