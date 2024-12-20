<?php
// Start session
session_start();

// Include database connection file
include_once 'connection.php';

// Initialize a message variable
$message = '';

// Handle Sign Up form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    // Get form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']); // This should be numeric
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if email already exists
    $check_email_query = "SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($conn, $check_email_query);

    if (mysqli_num_rows($result) > 0) {
        // Email already exists
        $message = 'Email already exists. Please use a different email.';
    } else {
        // Hash the password before storing it
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert user data into the database (including mobile number)
        $insert_query = "INSERT INTO user (name, email, mobile, password) VALUES ('$name', '$email', '$mobile', '$hashed_password')";

        if (mysqli_query($conn, $insert_query)) {
            // Registration successful, store session and redirect to profile
            $_SESSION['user_email'] = $email;
            $message = 'Registration successful! Redirecting to your profile...';
            header("refresh:2;url=profile.php"); // Redirect after 2 seconds
            exit();
        } else {
            $message = 'Something went wrong. Please try again.';
        }
    }
}

// Handle Sign In form submission (no change needed for sign-in)
// Handle Sign In form submission
// Handle Sign In form submission
// Handle Sign In form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signin'])) {
  // Get form data
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  // Check if email exists and password is correct
  $check_user_query = "SELECT * FROM user WHERE email = '$email'";
  $result = mysqli_query($conn, $check_user_query);

  if (mysqli_num_rows($result) > 0) {
      $user = mysqli_fetch_assoc($result);

      // Verify password
      if (password_verify($password, $user['password'])) {
          // Password is correct, store session
          $_SESSION['user_email'] = $email;

          // Redirect based on email
          if ($email === 'admin@gmail.com') {
              header("Location: foodAdmin.php"); // Redirect to food admin page
          } elseif ($email === 'billadmin@gmail.com') {
              header("Location: billAdmin.php"); // Redirect to bill admin page
          } else {
              header("Location: profile.php"); // Redirect to profile for regular users
          }
          exit();
      } else {
          $message = 'Incorrect password. Please try again.';
      }
  } else {
      $message = 'Email not found. Please sign up.';
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>HOME</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <style>
    /* Custom Styles */
    body {
      background-color: #f8f9fa;
    }

    .navbar {
      margin-bottom: 20px;
    }

    .navbar-nav {
      margin-left: auto;
    }

    .nav-link {
      font-weight: bold;
      color: white !important;
    }

    .nav-link:hover {
      color: #007bff !important;
    }

    .nav-item.active .nav-link {
      color: #007bff !important;
      font-weight: bold;
    }

    #heading1 {
      text-align: center;
      color: #343a40;
      font-weight: bold;
      margin-top: 20px;
    }

    #wel p {
      font-size: 1.2rem;
      text-align: justify;
      padding: 20px;
    }

    .sign-up, .sign-in {
      background-color: #fff;
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      margin-top: 30px;
    }

    .sign-up h3, .sign-in h3 {
      text-align: center;
      margin-bottom: 20px;
    }

    .footer {
      margin-top: 50px;
      text-align: center;
      padding: 20px;
      background-color: #343a40;
      color: white;
    }

    /* Add more space between Sign Up and Sign In */
    .sign-up {
      margin-right: 30px;
    }

    /* Style for alert messages */
    .alert-info {
      text-align: center;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">HOME</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="profile.php">PROFILE</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about.php">ABOUT</a>
      </li>
    </ul>
  </nav>

  <!-- Welcome Section -->
  <div id="wel">
    <h2 id="heading1">WELCOME TO EXPRESS FOODS</h2>
    <p>
    We provide you Amazing, Delicious Foods 
    Crafted with passion, served with love. Every dish is a celebration of fresh ingredients and bold flavors, curated to tantalize your taste buds. From farm to table, we bring you the finest cuisine, prepared by chefs who pour their heart into every plate. Whether you're here for a cozy dinner or a grand feast, we promise an unforgettable culinary journey. Discover the art of dining with us where each bite tells a story of flavor, tradition, and innovation.
    </p>
  </div>

  <!-- Sign Up and Sign In Section -->
  <div class="container">
    <div class="row justify-content-center">
      <!-- Sign Up Section -->
      <div class="col-md-5 sign-up">
        <h3>Sign Up</h3>
        <!-- Display message (error or success) -->
        <?php if (!empty($message)) : ?>
          <div class="alert alert-info">
            <?php echo $message; ?>
          </div>
        <?php endif; ?>
        <form action="" method="post">
          <div class="form-group">
            <label for="name">Full Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <div class="form-group">
            <label for="mobile">Mobile Number:</label>
            <input type="text" class="form-control" id="mobile" name="mobile" required>
          </div>
          <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <button type="submit" class="btn btn-primary btn-block" name="signup">Sign Up</button>
        </form>
      </div>

      <!-- Sign In Section -->
      <div class="col-md-5 sign-in">
        <h3>Sign In</h3>
        <form action="" method="post">
          <div class="form-group">
            <label for="email-login">Email:</label>
            <input type="email" class="form-control" id="email-login" name="email" required>
          </div>
          <div class="form-group">
            <label for="password-login">Password:</label>
            <input type="password" class="form-control" id="password-login" name="password" required>
          </div>
          <button type="submit" class="btn btn-success btn-block" name="signin">Sign In</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <div class="footer">
    <p>Follow us on Facebook, Instagram, and YouTube</p>
  </div>

</body>
</html>
