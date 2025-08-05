<?php
include "../config/db.php";

$errors = [];
$success = "";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../users/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Form submit check
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect data
    $product_id     = trim($_POST['product_id']);
    $fullname       = trim($_POST['fullname']);
    $email          = trim($_POST['email']);
    $phone          = trim($_POST['phone']);
    $address        = trim($_POST['address']);
    $quantity       = trim($_POST['quantity']);
    $price          = trim($_POST['price']);
    $payment_method = trim($_POST['payment_method']);
    $note           = trim($_POST['note']);

    // Validation
    if (empty($fullname))        $errors[] = "Full Name is required.";
    if (empty($email))           $errors[] = "Email is required.";
    if (empty($phone))           $errors[] = "Phone Number is required.";
    if (empty($address))         $errors[] = "Address is required.";
    if (empty($quantity) || $quantity < 1) $errors[] = "Please select valid quantity.";
    if (empty($payment_method))  $errors[] = "Payment method is required.";

    // If no errors, proceed to insert
    if (empty($errors)) {
        $conn = mysqli_connect("localhost", "root", "", "ecommerce");
        
        $query = "INSERT INTO orders (product_id, user_id, fullname, email, phone, address, quantity, price, payment_method, note)
          VALUES ('$product_id', '$user_id', '$fullname', '$email', '$phone', '$address', '$quantity', '$price', '$payment_method', '$note')";



        if (mysqli_query($conn, $query)) {
            $success = "✅ Order placed successfully!";
        } else {
            $errors[] = "❌ Failed to place order: " . mysqli_error($conn);
        }
    }
}
?>

<!-- ✅ Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php elseif (!empty($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
        <!-- <a href="../index.php" class="btn btn-primary">Back to Home</a> -->
    <?php 
        header("Location: thank_you.php");
        exit;
        
    endif; 
    ?>
</div>
