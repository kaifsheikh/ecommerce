<?php
include '../../config/db.php';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $errors[] = "Please fill in all fields.";
    } else {
        $query = "SELECT * FROM users WHERE email = '$email' AND role = 'admin' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) === 1) {
            $admin = mysqli_fetch_assoc($result);

            if ($admin['status'] !== "approved") {
                $errors[] = "Your account is not approved.";
            } elseif (password_verify($password, $admin['password'])) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['name'];
                $_SESSION['role'] = $admin['role'];
                header("Location: ../dashboard.php");
                exit;
            } else {
                $errors[] = "Invalid credentials.";
            }
        } else {
            $errors[] = "Admin account not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Mobile Fit -->
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e3f2fd, #bbdefb);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            max-width: 420px;
            width: 100%;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            padding: 2rem;
        }
        @media (max-width: 576px) {
            .login-card {
                padding: 1.5rem;
                margin: 1rem;
            }
        }
    </style>
</head>
<body>

<div class="login-card">
    <h3 class="text-center mb-4 fw-bold text-primary">Admin Login</h3>

    <!-- Error Messages -->
    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php foreach ($errors as $e) echo "<div>$e</div>"; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Login Form -->
    <form method="POST">
        <div class="mb-3">
            <label class="form-label fw-semibold">Email Address</label>
            <input type="email" name="email" class="form-control form-control-lg" required placeholder="Enter your email">
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Password</label>
            <input type="password" name="password" class="form-control form-control-lg" required placeholder="Enter your password">
        </div>
        <button type="submit" class="btn btn-primary w-100 btn-lg">Login</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
