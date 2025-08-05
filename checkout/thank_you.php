<?php
// Optional: Start session if you want to use session values
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thank You | Order Confirmed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container text-center mt-5">
    <div class="card p-5 shadow-sm">
        <h1 class="text-success mb-4">🎉 Thank You!</h1>
        <p class="lead">Your order has been placed successfully.</p>
        <p>You will receive a confirmation email or call shortly.</p>
        <hr>
        <a href="../index.php" class="btn btn-primary mt-3">Continue Shopping</a>
    </div>
</div>

</body>
</html>
