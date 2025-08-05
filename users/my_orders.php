<?php
include('../config/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT o.*, p.name AS product_name, p.image1 
          FROM orders o 
          JOIN products p ON o.product_id = p.id 
          WHERE o.user_id = '$user_id' 
          ORDER BY o.created_at DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>My Orders</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    img.product-thumb { width: 60px; border-radius: 6px; }
  </style>
</head>
<body class="bg-light">
<div class="container py-5">
  <h2 class="mb-4">🛒 My Orders</h2>

  <?php if (mysqli_num_rows($result) > 0): ?>
    <table class="table table-bordered table-hover">
      <thead class="table-dark">
        <tr>
          <th>Product</th>
          <th>Image</th>
          <th>Quantity</th>
          <th>Total Price</th>
          <th>Status</th>
          <th>Ordered On</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td><?= htmlspecialchars($row['product_name']) ?></td>
            <td><img src="../images/uploads/<?= $row['image1'] ?>" width="60" height="60"></td>
            <td><?= $row['quantity'] ?></td>
            <td>Rs. <?= $row['price'] ?></td>
            <td>
              <span class="badge bg-<?= 
                $row['status'] === 'approved' ? 'success' : 
                ($row['status'] === 'rejected' ? 'danger' : 'warning') ?>">
                <?= ucfirst($row['status']) ?>
              </span>
            </td>
            <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="alert alert-info">You have not placed any orders yet.</div>
  <?php endif; ?>
</div>
</body>
</html>
