<?php
// Start session
session_start();

// Include database connection file
include_once 'connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: index.php");
    exit();
}

// Get user email from session
$user_email = $_SESSION['user_email'];

// Fetch user's bills from the payment table, ordered by date (newest first)
$query = "SELECT * FROM payments WHERE user_email = '$user_email' ORDER BY payment_date DESC";
$result = mysqli_query($conn, $query);
$bills = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Bills</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .bills-container {
            margin-top: 30px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .bill-card {
            border: 1px solid #007bff;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .bill-card h5 {
            margin-bottom: 10px;
        }
        .bill-card p {
            margin-bottom: 5px;
        }
        .back-btn {
            position: absolute;
            left: 15;
            /* padding-left: 20px; */
        }
    </style>
</head>
<body>

<div class="container">
    <div class="bills-container">
        <div class="d-flex align-items-center">
            <!-- Back Button -->
            <a href="profile.php" class="btn btn-secondary back-btn">Back</a>
            <h2 class="mx-auto">My Bills</h2> <!-- mx-auto to center the heading -->
        </div>

        <?php if (count($bills) > 0): ?>
            <?php foreach ($bills as $bill): ?>
                <div class="bill-card">
                    <h5>Bill ID: <?php echo htmlspecialchars($bill['payment_reference']); ?></h5>
                    <p><strong>Date:</strong> <?php echo htmlspecialchars($bill['payment_date']); ?></p>
                    <p><strong>Time:</strong> <?php echo htmlspecialchars($bill['payment_time']); ?></p>
                    <p><strong>Total Amount:</strong> <?php echo htmlspecialchars($bill['total_amount']); ?> LKR</p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">No bills found.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
