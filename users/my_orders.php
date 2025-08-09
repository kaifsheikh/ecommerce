<?php
include('../config/db.php');
include "../includes/top-bar.php";

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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    img.product-thumb { 
      width: 60px; 
      height: 60px;
      object-fit: cover;
      border-radius: 6px; 
      border: 1px solid #ddd;
    }

    /* Mobile view */
    @media (max-width: 576px) {
      table {
        font-size: 12px;
      }
      table th, table td {
        padding: 6px;
      }
      img.product-thumb {
        width: 40px;
        height: 40px;
      }
      h2 {
        font-size: 18px;
      }
    }
  </style>
</head>
<body class="bg-light">

<div class="container mt-5">
  
  <!-- Back Button -->
  <div class="mb-3">
    <a href="javascript:history.back()" class="btn btn-outline-secondary btn-sm">
      &larr; Back
    </a>
  </div>

  <!-- Card -->
  <div class="card shadow border-0">
    <div class="card-header bg-dark text-white text-center">
      <h4 class="mb-0">🛒 My Orders</h4>
    </div>
    <div class="card-body">

      <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="table-responsive">
          <table class="table table-hover align-middle text-center">
            <thead class="table-dark">
              <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Feedback</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                  <!-- Product Column -->
                  <td class="text-start">
                    <div class="d-flex align-items-center">
                      <img src="../images/uploads/<?= $row['image1'] ?>" class="product-thumb me-2">
                      <span><?= htmlspecialchars($row['product_name']) ?></span>
                    </div>
                  </td>

                  <td><?= $row['quantity'] ?></td>
                  <td><strong>Rs. <?= number_format($row['price']) ?></strong></td>

                  <!-- Status -->
                  <td>
                    <span class="badge bg-<?= 
                      $row['status'] === 'approved' ? 'success' : 
                      ($row['status'] === 'rejected' ? 'danger' : 'warning') ?> px-3 py-2">
                      <?= ucfirst($row['status']) ?>
                    </span>
                  </td>

                  <!-- Feedback -->
                  <td>
                    <?php if($row['status'] == "approved" && empty($row['feedback'])): ?>
                      <a href="../feedback/give_feedback.php?order_id=<?= $row['id'] ?>" 
                         class="btn btn-sm btn-outline-success">Give Feedback</a>

                    <?php elseif(!empty($row['feedback'])): ?>
                      <span class="badge bg-success px-3 py-2">Given</span>
                    <?php else: ?>
                      <span class="text-muted">N/A</span>
                    <?php endif; ?>
                  </td>

                  <!-- Date -->
                  <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <div class="alert alert-info text-center shadow-sm mb-0">You have not placed any orders yet.</div>
      <?php endif; ?>

    </div>
  </div>
</div>

</body>
</html>
