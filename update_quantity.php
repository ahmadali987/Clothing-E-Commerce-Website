<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['index']) && isset($_POST['action'])) {
    // Validate and sanitize the incoming data
    $index = filter_input(INPUT_POST, 'index', FILTER_VALIDATE_INT);
    $action = $_POST['action']; // This should be 'increase' or 'decrease'

    if ($index !== false && ($action === 'increase' || $action === 'decrease')) {
        // Update quantity based on the action received (increase or decrease)
        if (isset($_SESSION['cart'][$index])) {
            if ($action === 'increase') {
                $_SESSION['cart'][$index]['quantity']++;
            } elseif ($action === 'decrease' && $_SESSION['cart'][$index]['quantity'] > 1) {
                $_SESSION['cart'][$index]['quantity']--;
            }

            // Send a success response
            http_response_code(200);
            echo json_encode(['message' => 'Quantity updated successfully']);
            exit;
        }
    }
}

// If the request doesn't meet the criteria or encounters an error, send an error response
http_response_code(400);
echo json_encode(['message' => 'Error: Unable to update quantity']);
?>
