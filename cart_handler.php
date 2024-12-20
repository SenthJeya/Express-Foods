<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $food_name = $_POST['food_name'];
    $food_price = $_POST['food_price'];
    $quantity = $_POST['quantity'];

    // Initialize cart if not already set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add item to cart
    $item = [
        'name' => $food_name,
        'price' => $food_price,
        'quantity' => $quantity,
    ];

    // Check if item already exists in cart, update the quantity
    $isItemFound = false;
    foreach ($_SESSION['cart'] as &$cartItem) {
        if ($cartItem['name'] === $food_name) {
            $cartItem['quantity'] += $quantity;
            $isItemFound = true;
            break;
        }
    }

    if (!$isItemFound) {
        $_SESSION['cart'][] = $item;
    }

    // Return a response
    echo json_encode(['status' => 'success', 'message' => 'Item added to cart!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>
