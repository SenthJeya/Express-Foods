<?php
session_start();
include_once 'connection.php'; // Include your database connection

// Check if the cart is empty, and if it is, redirect back with a message
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<script>alert('Cart is Empty'); window.location.href = 'profile.php';</script>";
    exit();
}

// Get cart items and calculate total amount
$cart_items = $_SESSION['cart'];
$total_amount = 0;
foreach ($cart_items as $item) {
    $total_amount += $item['price'] * $item['quantity'];
}

// Handle payment submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form inputs
    $user_name = $_POST['user_name'];
    $mobile_number = $_POST['mobile_number'];
    $card_number = implode('-', [$_POST['card_number_1'], $_POST['card_number_2'], $_POST['card_number_3'], $_POST['card_number_4']]);
    $expiry_date = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];

    // Generate a 6-digit payment reference number
    $payment_reference = rand(100000, 999999);

    // Get current date and time
    $current_date = date("Y-m-d");
    $current_time = date("H:i:s");

    // Get user email from session
    $user_email = $_SESSION['user_email'];

    // Store payment details in the database (assumed table: 'payments')
    $payment_query = "INSERT INTO payments (user_name, user_email, mobile_number, total_amount, payment_reference, payment_date, payment_time) 
                      VALUES ('$user_name', '$user_email', '$mobile_number', '$total_amount', '$payment_reference', '$current_date', '$current_time')";

    if (mysqli_query($conn, $payment_query)) {
        // On successful payment, clear the cart and redirect to success page with payment reference
        unset($_SESSION['cart']);
        header("Location: payment_success.php?message=Payment+Successful&reference=$payment_reference");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Payment</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script>
        // JavaScript logic for automatic field movement and formatting
        function moveToNext(current, nextFieldId) {
            if (current.value.length === current.maxLength) {
                document.getElementById(nextFieldId).focus();
            }
        }

        function formatExpiryDate(input) {
            let value = input.value.replace(/\D/g, '');
            if (value.length >= 2) {
                input.value = value.slice(0, 2) + '/' + value.slice(2);
            } else {
                input.value = value;
            }

            if (value.length >= 4) {
                document.getElementById('cvv').focus();
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Payment</h2>

        <!-- Display total amount -->
        <h3>Total Amount to Pay: <?php echo $total_amount; ?> LKR</h3>

        <!-- Payment form -->
        <form method="post" action="payment.php">
            <!-- Name Field -->
            <div class="form-group">
                <label for="user_name">Full Name:</label>
                <input type="text" class="form-control" id="user_name" name="user_name" required>
            </div>

            <!-- Mobile Number Field -->
            <div class="form-group">
                <label for="mobile_number">Mobile Number:</label>
                <input type="text" class="form-control" id="mobile_number" name="mobile_number" maxlength="10" required>
            </div>

            <!-- Card Number Fields -->
            <div class="form-group">
                <label for="card_number">Card Number:</label>
                <div class="form-row">
                    <div class="col">
                        <input type="text" class="form-control" id="card_number_1" name="card_number_1" maxlength="4" onkeyup="moveToNext(this, 'card_number_2')" required>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" id="card_number_2" name="card_number_2" maxlength="4" onkeyup="moveToNext(this, 'card_number_3')" required>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" id="card_number_3" name="card_number_3" maxlength="4" onkeyup="moveToNext(this, 'card_number_4')" required>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" id="card_number_4" name="card_number_4" maxlength="4" onkeyup="moveToNext(this, 'expiry_date')" required>
                    </div>
                </div>
            </div>

            <!-- Expiration Date and CVV -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="expiry_date">Expiration Date (MM/YY):</label>
                    <input type="text" class="form-control" id="expiry_date" name="expiry_date" maxlength="5" onkeyup="formatExpiryDate(this)" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="cvv">CVV:</label>
                    <input type="text" class="form-control" id="cvv" name="cvv" maxlength="3" required>
                </div>
            </div>

            <!-- Submit Payment Button -->
            <button type="submit" class="btn btn-success btn-block">Submit Payment</button>
        </form>
    </div>
</body>
</html>
