<?php
include "../config/db.php";

// Initialize error array
$errors = [];
$success = "";

// Form Submit Check
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($name)) {
        $errors[] = "Full name is required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    $check = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) {
        $errors[] = "Email already registered.";
    }

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, email, password, status, role) VALUES ('$name', '$email', '$hashedPassword', 'approved', 'user')";

        if (mysqli_query($conn, $sql)) {
            $success = "Registration successful!";
        } else {
            $errors[] = "Database error: " . mysqli_error($conn);
        }
    }
}
?>

<?php include "../assets/css/bootstrap_files.html"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            background: #f2f2f2;
            font-family: 'Segoe UI', sans-serif;
        }

        .register-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 15px;
        }

        .register-card {
            width: 100%;
            max-width: 400px;
            background: #fff;
            border-radius: 12px;
            padding: 30px 25px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .register-card h3 {
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
            .register-card {
                padding: 25px 20px;
            }

            .register-card h3 {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>

    <div class="register-wrapper">
        <div class="register-card">
            <h3 class="text-center mb-4">Register</h3>
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
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>

            <p class="text-center mt-3 extra-links">
                Already registered? <a href="login.php">Login</a>
            </p>
        </div>
    </div>

</body>

</html>