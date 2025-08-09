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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .table thead th {
            white-space: nowrap;
        }
        @media (max-width: 768px) {
            h2 {
                font-size: 1.3rem;
            }
            .btn {
                font-size: 0.8rem;
                padding: 5px 10px;
            }
        }
    </style>
</head>
<body>

<div class="container mt-4">

    <!-- Header with Back Button -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0 text-primary fw-bold">🧾 All Orders</h2>
        <a href="../dashboard.php" class="btn btn-outline-secondary">
            ← Back to Dashboard
        </a>
    </div>

    <!-- Card for Table -->
    <div class="card shadow-lg border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark text-center">
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
                            <th>View Order</th>
                            <th>Placed On</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= htmlspecialchars($row['product_name']) ?></td>
                                <td><?= htmlspecialchars($row['fullname']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['phone']) ?></td>
                                <td><?= $row['quantity'] ?></td>
                                <td><strong>PKR <?= number_format($row['price'], 2) ?></strong></td>
                                <td><?= htmlspecialchars($row['payment_method']) ?></td>

                                <td>
                                    <?php if ($row['status'] === 'pending'): ?>
                                        <a href="update_status.php?id=<?= $row['id'] ?>&status=approved" class="btn btn-sm btn-success">Approve</a>
                                        <a href="update_status.php?id=<?= $row['id'] ?>&status=rejected" class="btn btn-sm btn-danger">Reject</a>
                                    <?php else: ?>
                                        <span class="badge bg-<?= $row['status'] === 'approved' ? 'success' : 'danger' ?>">
                                            <?= ucfirst($row['status']) ?>
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <a href="view_order_detail.php?id=<?= $row['id'] ?>" class="btn btn-sm badge bg-primary">
                                        View Details
                                    </a>
                                </td>

                                <td><?= date('d-M-Y', strtotime($row['created_at'])) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

</body>
</html>
