<?php
include "../../config/db.php";
include "../includes/session_check.php"; // Session Check

$query = "SELECT o.*, p.name AS product_name 
          FROM orders o 
          JOIN products p ON o.product_id = p.id 
          ORDER BY o.created_at DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">


    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">🧾 All Orders</h2>
        <a href="../dashboard.php" class="btn btn-secondary">
            ← Back to Dashboard
        </a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#ID</th>
                <th>Product</th>
                <th>Customer</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Quantity</th>
                <th>Price (Total)</th>
                <th>Payment</th>
                <th>Status</th>
                <th>View Client Order</th>
                <th>Placed On</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['product_name']) ?></td>
                    <td><?= htmlspecialchars($row['fullname']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['phone']) ?></td>
                    <td><?= $row['quantity'] ?></td>
                    <td>PKR <?= number_format($row['price'], 2) ?></td>
                    <td><?= htmlspecialchars($row['payment_method']) ?></td>
                    <!-- <td>
                        <span class="badge bg-<?= 
                            $row['status'] === 'approved' ? 'success' : 
                            ($row['status'] === 'rejected' ? 'danger' : 'warning'
                        ) ?>">
                            <?= ucfirst($row['status']) ?>
                        </span>
                    </td> -->
                    
                    <!-- Approve or Reject -->
                     <td>
                        <?php if ($row['status'] === 'pending'): ?>
                            <a href="update_status.php?id=<?= $row['id'] ?>&status=approved" class="btn btn-sm btn-success">Approve</a>
                            <a href="update_status.php?id=<?= $row['id'] ?>&status=rejected" class="btn btn-sm btn-danger">Reject</a>
                        <?php else: ?>

                            <span class="badge bg-<?= 
                                $row['status'] === 'approved' ? 'success' : 'danger'
                            ?>">
                                <?= ucfirst($row['status']) ?>
                            </span>
                        <?php endif; ?>
                    </td>
                      
                    <td>
                        <a href="view_order_detail.php?id=<?= $row['id'] ?>" class="btn btn-primary badge btn-sm">
                            View Details
                        </a>
                    </td>

                    
                    <td><?= date('d-M-Y', strtotime($row['created_at'])) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
