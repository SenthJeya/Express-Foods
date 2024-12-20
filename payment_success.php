<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Payment Success</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="text-center text-success">Payment Successful!</h2>
        <p class="text-center"><?php echo htmlspecialchars($_GET['message']); ?></p>
        <p class="text-center">Your Payment Reference Number: <strong><?php echo htmlspecialchars($_GET['reference']); ?></strong></p>
        <a href="profile.php" class="btn btn-primary btn-block">Go Back to Profile</a>
    </div>
</body>
</html>
