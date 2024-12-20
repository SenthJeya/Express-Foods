<?php
// Start session
session_start();

// Include database connection file
include_once 'connection.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_email']) || $_SESSION['user_email'] !== 'admin@gmail.com') {
    header("Location: index.php");
    exit();
}

// Handle food addition
if (isset($_POST['add_food'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $path = mysqli_real_escape_string($conn, $_POST['path']);

    $insert_food_query = "INSERT INTO food (name, price, path) VALUES ('$name', '$price', '$path')";

    if (mysqli_query($conn, $insert_food_query)) {
        $message = 'Food added successfully!';
    } else {
        $error = 'Failed to add food. Please try again.';
    }
}

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
  <title>Admin Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .admin-container {
      margin-top: 30px;
      padding: 20px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .footer {
      margin-top: 50px;
      text-align: center;
      padding: 20px;
      background-color: #343a40;
      color: white;
    }
    .btn-row .col-md-6 {
      padding: 0 10px;
      margin-bottom: 15px; /* Space between buttons */
    }
    .btn-block {
      width: 100%;
    }
    .btn-space {
      margin-bottom: 15px; /* Space between the buttons */
    }
  </style>
</head>
<body>

  <!-- Admin Page Section -->
  <div class="container">
    <div class="admin-container">
      <h2 class="text-center">Food Admin</h2>
      
      <!-- Display message (success or error) -->
      <?php if (isset($message)) : ?>
        <div class="alert alert-success">
          <?php echo htmlspecialchars($message); ?>
        </div>
      <?php endif; ?>
      <?php if (isset($error)) : ?>
        <div class="alert alert-danger">
          <?php echo htmlspecialchars($error); ?>
        </div>
      <?php endif; ?>

      <!-- Food Addition Form -->
      <form method="post" action="">
        <div class="form-group">
          <label for="name">Food Name:</label>
          <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
          <label for="price">Price:</label>
          <input type="text" class="form-control" id="price" name="price" required>
        </div>
        <div class="form-group">
          <label for="path">Image Path:</label>
          <input type="text" class="form-control" id="path" name="path" required>
        </div>
        
        <!-- Add Food Button -->
        <div class="row btn-row">
          <div class="col-md-12">
            <button type="submit" class="btn btn-primary btn-block btn-space" name="add_food">Add Food</button>
          </div>
        </div>
      </form>

      <!-- Separate Logout Form -->
      <form method="post" action="">
        <div class="row btn-row">
          <div class="col-md-12">
            <button type="submit" class="btn btn-secondary btn-block" name="logout">Log Out</button>
          </div>
        </div>
      </form>

    </div>
  </div>

  <!-- Footer -->
  <div class="footer">
    <p>Follow us on Facebook, Instagram, and YouTube</p>
  </div>

</body>
</html>
