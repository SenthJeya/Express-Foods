<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $food_name = $_POST['food_name'];

    // Check if the cart exists and contains the item to be removed
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['name'] === $food_name) {
                // Remove the item from the cart
                unset($_SESSION['cart'][$key]);
            }
        }

        // Re-index the cart array
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
}

// Redirect back to the checkout page after removal
header("Location: checkout.php");
exit();
?>
