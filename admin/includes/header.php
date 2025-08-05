<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Anon - eCommerce Website</title>

  <!--
    - favicon
  -->
  <link rel="shortcut icon" href="../images/logo/favicon.ico" type="image/x-icon">

  <!--
    - custom css link
  -->
  <link rel="stylesheet" href="../assets/css/style-prefix.css">

  <!--
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">

  <!-- Sweet Alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

  <!--
    - HEADER
  -->

  <header>
    <!-- Logout Detial Page -->
    <div class="header-top">
      <div class="container">
        <div class="header-top-actions">

          <!-- Login -->
          <ul class="header-social-container">

            <?php if (isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') : ?>
              <!-- Logged In -->
              <span class="navbar-text me-3">Welcome, <?= $_SESSION['role']; ?></span>
              <a href="./users/logout.php" class="social-link">Logout</a>

            <?php else : ?>
              <!-- Not Logged In -->
              <a href="./users/login.php" class="social-link">Login</a>
              <a href="./users/register.php" class="social-link">Register</a>

            <?php endif; ?>

          </ul>

        </div>
      </div>
    </div>

  </header>