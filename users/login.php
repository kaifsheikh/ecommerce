<?php
include "../config/db.php";

$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    if (empty($errors)) {
        $sql = "SELECT * FROM users WHERE email = '$email' AND role = 'user'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                header("Location: ../index.php");
                exit;
            } else {
                $errors[] = "Incorrect password.";
            }
        } else {
            $errors[] = "No user found with that email.";
        }
    }
}
?>

<?php include "../assets/css/bootstrap_files.html"; ?>
<style>
  body {
    background: #f2f2f2;
    font-family: 'Segoe UI', sans-serif;
  }

  .login-wrapper {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 30px 15px;
  }

  .login-card {
    width: 100%;
    max-width: 400px;
    background: #fff;
    border-radius: 12px;
    padding: 30px 25px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  }

  .login-card h3 {
    font-weight: 600;
    margin-bottom: 20px;
  }

  .form-label {
    font-weight: 500;
    font-size: 14px;
  }

  .btn-primary {
    font-size: 15px;
    padding: 10px;
    font-weight: 600;
  }

  .extra-links {
    font-size: 13px;
  }

  .extra-links a {
    text-decoration: none;
  }

  @media (max-width: 576px) {
    .login-card {
      padding: 25px 20px;
    }
  }
</style>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <div class="login-wrapper">
    <div class="login-card">
      <h3 class="text-center">Login</h3>
      
      <form method="POST" action="">
        <!-- Error Messages -->
        <?php if (!empty($errors)) : ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
              <?php foreach ($errors as $error) : ?>
                <li><?= $error ?></li>
              <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        <?php endif; ?>

        <!-- Success Message -->
        <?php if (!empty($success)) : ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $success ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        <?php endif; ?>

        <div class="mb-3">
          <label for="email" class="form-label">Email Address</label>
          <input type="email" name="email" class="form-control" id="email" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" class="form-control" id="password" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>
      </form>

      <div class="text-center mt-3 extra-links">
        <p>Don't have an account? <a href="register.php">Register</a></p>
        <p><a href="../index.php">← Back to shopping</a></p>
      </div>
    </div>
  </div>
</body>
</html>
