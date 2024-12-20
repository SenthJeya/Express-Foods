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

// Handle profile update
if (isset($_POST['save_changes'])) {
    $new_name = mysqli_real_escape_string($conn, $_POST['new_name']);
    $new_mobile = mysqli_real_escape_string($conn, $_POST['new_mobile']);

    // Validate inputs
    if (!empty($new_name) && !empty($new_mobile)) {
        // Update user information
        $update_query = "UPDATE user SET name='$new_name', mobile='$new_mobile' WHERE email='$email'";
        if (mysqli_query($conn, $update_query)) {
            header("Location: profile.php?message=Profile updated successfully!");
            exit();
        } else {
            $message = "Failed to update profile.";
        }
    } else {
        $message = "Name and Mobile Number cannot be empty.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Edit Profile</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .edit-profile-container {
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
    .btn-row {
      margin-top: 20px;
    }
    .btn-row .col-md-6 {
      padding: 0 10px; /* Equal gap between buttons */
    }
  </style>
</head>
<body>

  <!-- Edit Profile Section -->
  <div class="container">
    <div class="edit-profile-container">
      <h2 class="text-center">Edit Profile</h2>

      <!-- Display message (success or error) -->
      <?php if (isset($message)) : ?>
        <div class="alert alert-info">
          <?php echo htmlspecialchars($message); ?>
        </div>
      <?php endif; ?>
      
      <form method="post" action="">
        <div class="form-group">
          <label for="new_name">New Username:</label>
          <input type="text" class="form-control" id="new_name" name="new_name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
        </div>
        <div class="form-group">
          <label for="new_mobile">New Mobile Number:</label>
          <input type="text" class="form-control" id="new_mobile" name="new_mobile" value="<?php echo htmlspecialchars($user['mobile']); ?>" required>
        </div>

        <!-- Buttons Row -->
        <div class="row btn-row">
          <div class="col-md-6">
            <a href="profile.php" class="btn btn-secondary btn-block">Back</a>
          </div>
          <div class="col-md-6">
            <button type="submit" class="btn btn-primary btn-block" name="save_changes">Save Changes</button>
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
