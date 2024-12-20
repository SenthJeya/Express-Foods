<?php
session_start();

// Check if the cart is empty, and if it is, redirect back with a message
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<script>alert('Cart is Empty'); window.location.href = 'profile.php';</script>";
    exit();
}

// Get cart items
$cart_items = $_SESSION['cart'];
$total_amount = 0;

// Handle clearing the cart when "Back" button is clicked
if (isset($_POST['clear_cart'])) {
    unset($_SESSION['cart']); // Clear the cart session
    header("Location: profile.php"); // Redirect to the homepage or previous page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Checkout</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <h2 class="text-center">Checkout</h2>
    
    <!-- Cart Table -->
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Item Name</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Total</th>
          <th>Action</th> <!-- Column for the Remove button -->
        </tr>
      </thead>
      <tbody>
        <?php foreach ($cart_items as $item) : ?>
          <tr>
            <td><?php echo htmlspecialchars($item['name']); ?></td>
            <td><?php echo htmlspecialchars($item['price']); ?> LKR</td>
            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
            <td><?php echo htmlspecialchars($item['price'] * $item['quantity']); ?> LKR</td>
            <td>
              <!-- Remove item form -->
              <form method="post" action="cart_remove.php">
                <input type="hidden" name="food_name" value="<?php echo htmlspecialchars($item['name']); ?>">
                <button type="submit" class="btn btn-danger">Remove</button>
              </form>
            </td>
          </tr>
          <?php $total_amount += $item['price'] * $item['quantity']; ?>
        <?php endforeach; ?>
      </tbody>
    </table>
    
    <!-- Total Amount -->
    <h3>Total Amount: <?php echo $total_amount; ?> LKR</h3>
    
    <!-- Buttons for Checkout and Back -->
    <div class="row">
      <div class="col-md-6">
        <a href="payment.php" class="btn btn-primary btn-block">Proceed to Payment</a>
      </div>
      <div class="col-md-6">
        <!-- Back button to clear the cart and go back -->
        <form method="post" action="">
          <button type="submit" name="clear_cart" class="btn btn-secondary btn-block">Back</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
