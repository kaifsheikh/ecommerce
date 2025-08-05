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
  <link rel="shortcut icon" href="./assets/images/logo/favicon.ico" type="image/x-icon">

  <!--
    - custom css link
  -->
  <link rel="stylesheet" href="./assets/css/style-prefix.css">

  <!--
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">


  <!-- Sweet Alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Mobile Width -->
  <style>
    /* Hide by default (desktop) */
    .login-mobile {
      display: none;
    }

    /* Show only on mobile (<= 768px) */
    @media (max-width: 768px) {
      .login-mobile {
        display: inline-block;
        margin-top: 10px;
        /* Optional spacing */
        /* Example styling */
        /* color: white; */
        /* padding: 8px 16px; */
        border-radius: 4px;
        text-align: center;
        text-decoration: none;
      }
    }
  </style>
</head>

<body>

  <div class="overlay" data-overlay></div>

  <!--
    - MODAL
  -->

  <!-- <div class="modal" data-modal>
    <div class="modal-close-overlay" data-modal-overlay></div>

    <div class="modal-content">

      <button class="modal-close-btn" data-modal-close>
        <ion-icon name="close-outline"></ion-icon>
      </button>

      <div class="newsletter-img">
        <img src="images/adds/newsletter.png" alt="subscribe newsletter" width="400" height="400">
      </div>

      <div class="newsletter">

        <form action="#">

          <div class="newsletter-header">

            <h3 class="newsletter-title">Subscribe Newsletter.</h3>

            <p class="newsletter-desc">
              Subscribe the <b>Anon</b> to get latest products and discount update.
            </p>

          </div>

          <input type="email" name="email" class="email-field" placeholder="Email Address" required>

          <button type="submit" class="btn-newsletter">Subscribe</button>

        </form>

      </div>

    </div>

  </div> -->

  <!--
    - NOTIFICATION TOAST
  -->
  <!-- <div class="notification-toast" data-toast>

    <button class="toast-close-btn" data-toast-close>
      <ion-icon name="close-outline"></ion-icon>
    </button>

    <div class="toast-banner">
      <img src="./assets/images/products/jewellery-1.jpg" alt="Rose Gold Earrings" width="80" height="70">
    </div>

    <div class="toast-detail">

      <p class="toast-message">
        Someone in new just bought
      </p>

      <p class="toast-title">
        Rose Gold Earrings
      </p>

      <p class="toast-meta">
        <time datetime="PT2M">2 Minutes</time> ago
      </p>

    </div>

  </div> -->





  <!--
    - HEADER
  -->

  <header>

    <!-- Desktop Width Section 1 -->
    <div class="header-top">
      <div class="container">


        <!-- Desktop Width -->
        <ul class="header-social-container">

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-facebook"></ion-icon>
            </a>
          </li>

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-twitter"></ion-icon>
            </a>
          </li>

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-instagram"></ion-icon>
            </a>
          </li>

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-linkedin"></ion-icon>
            </a>
          </li>

        </ul>


        <!-- Desktop Width -->
        <div class="header-alert-news">
          <p>
            <b>Free Shipping</b>
            This Week Order Over - $55
          </p>
        </div>


        <!-- Desktop Width -->
        <div class="header-top-actions">

          <!-- Login -->
          <ul class="header-social-container">

            <?php if (isset($_SESSION['user_id'])) : ?>
              <!-- Logged In -->
              <span class="navbar-text me-3">Welcome, <?= $_SESSION['user_name']; ?></span>
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



    <!-- Desktop Widht Section 2 -->
    <div class="header-main">
      <div class="container">


        <a href="#" class="header-logo">
          <img src="/ecommerce/images/logo/logo.svg" alt="Anon's logo" width="120" height="36">
        </a>


        <!-- Search Functionality -->
        <div class="header-search-container">
          <form action="includes/search.php" method="GET">
            <input type="search" name="search" class="search-field" placeholder="Enter your product name...">

            <button type="submit" class="search-btn">
              <ion-icon name="search-outline"></ion-icon>
            </button>
          </form>
        </div>


        <!-- Login Button Mobile Width Only -->
        <?php
        if (session_status() === PHP_SESSION_NONE) {
          session_start();
        }
        
        if (!isset($_SESSION['user_id'])):
        ?>
         <!-- Mobile width Login -->
          <a href="./users/login.php" class="banner-btn login-mobile">
            Login
          </a>

   
            <!-- <div class="desktop-navigation-menu">
            <ul class="desktop-menu-category-list">
                <li class="menu-category">
                    <a href="#" class="menu-title">Home</a>
                </li>
            </ul>
            </div> -->



        <?php endif; ?>
      


      
        <!-- Desktop Widht -->
        <?php
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
          session_start();
        }

        if (isset($_SESSION['user_id'])):
        ?>
        <div class="header-user-actions">

            <!-- Orders Button -->
            <a href="./users/my_orders.php" class="action-btn">
              <ion-icon name="bag-handle-outline"></ion-icon>
            </a>

          </div>
        <?php endif; ?> <!-- If Close here -->

      </div>


      <!-- Mobile Widht Navbar -->
  <?php
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    ?>
    <?php if (isset($_SESSION['user_id'])): ?>
      <div class="mobile-bottom-navigation">

        <!-- My Order -->
        <a href="./users/my_orders.php" class="action-btn">
          <ion-icon name="bag-handle-outline"></ion-icon>
          <span class="count">0</span>
        </a>

        <!-- Logout -->
        <a href="./users/logout.php" class="banner-btn">
          Logout
        </a>
      </div>
  <?php endif; ?>

  </header>