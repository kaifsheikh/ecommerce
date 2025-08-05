<?php
include '../../config/db.php'; // adjust path if needed
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $errors[] = "Please fill in all fields.";

    } else {
        // Check if admin exists
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

                // Redirect to admin dashboard
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
<html>
<head>
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
<div class="container col-md-5">
    <h2 class="text-center mb-4">Admin Login</h2>

    <!-- Error Message -->
    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $e) echo "<div>$e</div>"; ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="card p-4 shadow">
        <div class="mb-3">
            <label>Email Address</label>
            <input type="email" name="email" class="form-control" required />
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required />
        </div>
        <button type="submit" class="btn btn-dark w-100">Login</button>
    </form>
</div>
</body>
</html>
