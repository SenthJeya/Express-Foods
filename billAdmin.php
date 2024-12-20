<?php
session_start();
include_once 'connection.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_email']) || $_SESSION['user_email'] !== 'billadmin@gmail.com') {
    header("Location: index.php");
    exit();
}

// Fetch all payment records from the database, ordering by payment_date in descending order
$payment_query = "SELECT * FROM payments ORDER BY payment_date DESC";
$payment_result = mysqli_query($conn, $payment_query);
$payments = mysqli_fetch_all($payment_result, MYSQLI_ASSOC);

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin - Payments</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <a class="navbar-brand" href="#">Admin Panel</a>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <form method="post">
                <button type="submit" name="logout" class="btn btn-danger">Log Out</button>
            </form>
        </li>
    </ul>
</nav>

<div class="container mt-5">
    <h2 class="text-center">All Payments</h2>

    <?php if (mysqli_num_rows($payment_result) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Payment Reference</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Mobile Number</th>
                    <th>Total Amount</th>
                    <th>Payment Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payments as $payment): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($payment['payment_reference']); ?></td>
                        <td><?php echo htmlspecialchars($payment['user_name']); ?></td>
                        <td><?php echo htmlspecialchars($payment['user_email']); ?></td>
                        <td><?php echo htmlspecialchars($payment['mobile_number']); ?></td>
                        <td><?php echo htmlspecialchars($payment['total_amount']); ?> LKR</td>
                        <td><?php echo htmlspecialchars($payment['payment_date']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">No payments found.</p>
    <?php endif; ?>
</div>

</body>
</html>
