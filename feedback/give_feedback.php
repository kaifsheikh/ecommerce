<?php
include('../config/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$order_id = $_GET['order_id'] ?? 0;

// Agar form submit ho gaya
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = $_POST['rating'];
    $feedback = mysqli_real_escape_string($conn, $_POST['feedback']);

    // Sirf apne order ka feedback update karna
    $sql = "UPDATE orders 
            SET rating = '$rating', feedback = '$feedback' 
            WHERE id = '$order_id' AND user_id = '$user_id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: give_feedback.php?order_id=$order_id&msg=Feedback Submitted Successfully");
        exit();
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Give Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2>Give Feedback</h2>

        <!-- Success Message -->
    <?php if (!empty($_GET['msg'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['msg']) ?></div>
    <?php endif; ?>

    <!-- Error Message -->
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Rating (1-5)</label>
            <input type="number" name="rating" min="1" max="5" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Your Feedback</label>
            <textarea name="feedback" class="form-control" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">Submit</button>
        <a href="../users/my_orders.php" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>
