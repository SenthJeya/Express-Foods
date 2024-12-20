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

// Get user information from the database
$email = $_SESSION['user_email'];
$query = "SELECT * FROM user WHERE email = '$email'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Handle delete profile
if (isset($_POST['delete_profile'])) {
    // Delete user data from the database
    $delete_query = "DELETE FROM user WHERE email = '$email'";
    if (mysqli_query($conn, $delete_query)) {
        session_destroy();
        header("Location: index.php?message=Profile+Deleted+Successfully");
        exit();
    } else {
        $error = "Failed to delete profile. Please try again.";
    }
}

// Fetch food details
$food_query = "SELECT name, price, path FROM food";
$food_result = mysqli_query($conn, $food_query);
$food_items = mysqli_fetch_all($food_result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Profile</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <style>
    body {
      background-color: #f8f9fa;
    }
    .profile-container h2 {
      text-align: center;
    }
    .profile-container {
      margin-top: 30px;
      padding: 20px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .profile-container, .food-container {
      margin-top: 30px;
      padding: 20px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .food-container {
      margin-top: 20px;
      position: relative; /* Required for absolute positioning of the Checkout button */
    }
    .food-container h3 {
      margin-bottom: 20px; /* Add space below the heading */
    }
    .food-container .food-item {
      margin-bottom: 20px;
      text-align: center;
    }
    .food-container .food-item img {
      max-width: 100%;
      height: auto;
    }
    .food-container .checkout-btn {
      position: absolute;
      top: 20px;
      right: 20px;
    }
    .footer {
      margin-top: 50px;
      text-align: center;
      padding: 20px;
      background-color: #343a40;
      color: white;
    }
    .btn-row {
      margin-top: 20px;
    }
    .btn-row .col-md-4 {
      padding: 0 10px; /* Equal gap between buttons */
    }
    .quantity-container {
      display: flex;
      justify-content: center; /* Center horizontally */
      align-items: center; /* Center vertically */
      margin-top: 10px; /* Adjust spacing if needed */
    }
    .quantity-input {
      width: 80px; /* Adjust width as needed */
      margin-left: 10px; /* Space between label and input */
    }
    /* Styling for active nav item */
    .navbar-nav .nav-item .nav-link.active {
      color: #007bff !important;
      font-weight: bold;
    }
    .navbar-nav .nav-item .nav-link {
      color: #ffffff; /* Default link color */
    }
    .food-container .food-item img {
      width: 150px; /* Set a fixed width */
      height: 150px; /* Set a fixed height */
      object-fit: cover; /* Ensures the image maintains aspect ratio and fits within the dimensions */
      border: 3px solid #007bff; /* Add a 3px blue border */
      border-radius: 8px; /* Optional: add rounded corners to the border */
}
  </style>

<script>
    $(document).ready(function() {
        $('.add-to-cart-form').on('submit', function(e) {
            e.preventDefault(); // Prevent the form from submitting normally
            var form = $(this);
            $.ajax({
                url: 'cart_handler.php',
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        alert(data.message);
                    } else {
                        alert(data.message);
                    }
                }
            });
        });
    });
  </script>

</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" href="index.php">HOME</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : ''; ?>" href="profile.php">PROFILE</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>" href="about.php">ABOUT</a>
      </li>
    </ul>
  </nav>

  <!-- Profile Section -->
  <div class="container">
    <div class="profile-container">
      <div class="d-flex justify-content-center align-items-center">
        <h2 class="flex-grow-1 text-center">User Profile</h2>
        <a href="mybills.php" class="btn btn-info">My Bills</a>
      </div>


    <!-- Display message (success or error) -->
      <?php if (isset($_GET['message'])) : ?>
      <div class="alert alert-info">
        <?php echo htmlspecialchars($_GET['message']); ?>
      </div>
      <?php endif; ?>
      <?php if (isset($error)) : ?>
      <div class="alert alert-danger">
        <?php echo htmlspecialchars($error); ?>
      </div>
      <?php endif; ?>
    
      <div class="row">
        <div class="col-md-6">
          <p><strong>Full Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
          <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
          <p><strong>Mobile Number:</strong> <?php echo htmlspecialchars($user['mobile']); ?></p> <!-- Added Phone Number -->
        </div>
      </div>

    <!-- Buttons Row -->
      <div class="row btn-row">
        <div class="col-md-4">
          <a href="profileEdit.php" class="btn btn-primary btn-block">Edit Profile</a>
        </div>
        <div class="col-md-4">
          <form method="post" action="">
            <button type="submit" class="btn btn-secondary btn-block" name="logout">Log Out</button>
          </form>
        </div>
        <div class="col-md-4">
          <form method="post" action="" onsubmit="return confirm('Are you sure you want to delete your profile? This action cannot be undone.');">
            <button type="submit" class="btn btn-danger btn-block" name="delete_profile">Delete Profile</button>
          </form>
        </div>
      </div>
    </div>

    
    <!-- Food Section -->
    <div class="food-container">
      <a href="checkout.php" class="btn btn-primary checkout-btn">Checkout</a>
      <h3 class="text-center">Food Details</h3>
      <div class="row">
        <?php foreach ($food_items as $food) : ?>
          <div class="col-md-3 food-item">
            <img src="<?php echo htmlspecialchars('./food/'.$food['path']); ?>" alt="<?php echo htmlspecialchars($food['name']); ?>">
            <h5><?php echo htmlspecialchars($food['name']); ?></h5>
            <p><?php echo htmlspecialchars($food['price']); ?> LKR</p>
            <form method="post" class="add-to-cart-form">
              <input type="hidden" name="food_name" value="<?php echo htmlspecialchars($food['name']); ?>">
              <input type="hidden" name="food_price" value="<?php echo htmlspecialchars($food['price']); ?>">
              <div class="quantity-container">
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" min="1" value="1" class="form-control quantity-input">
              </div>
              <button type="submit" class="btn btn-success mt-2">Add to Cart</button>
            </form>
          </div>
        <?php endforeach; ?>
    </div>
  </div>

  <!-- Footer -->
  <div class="footer">
    <p>Follow us on Facebook, Instagram, and YouTube</p>
  </div>

</body>
</html>