<?php
include "../../config/db.php";
include "../includes/session_check.php";

// ✅ Order ID from GET
if (!isset($_GET['id'])) {
    echo "Order ID missing.";
    exit;
}

$order_id = $_GET['id'];

// ✅ Join order + product detail
$query = "
    SELECT 
        o.*, 
        p.name AS product_name,
        p.description AS product_description,
        p.image1 AS product_image,
        p.price AS original_price,
        p.discount
    FROM orders o
    JOIN products p ON o.product_id = p.id
    WHERE o.id = $order_id
";

$result = mysqli_query($conn, $query);
$order = mysqli_fetch_assoc($result);

if (!$order) {
    echo "No order found!";
    exit;
}
?>

<!-- ✅ Bootstrap View Page -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container shadow p-3 rounded">
    
    <h3 class="mb-4">Order Details (Order #<?= $order['id'] ?>)</h3>

    <div class="row">
        <div class="col-md-5">
            <h5>🧾 Customer Info</h5>
            <p><strong>Name:</strong> <?= htmlspecialchars($order['fullname']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($order['email']) ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($order['phone']) ?></p>
            <p><strong>Address:</strong> <?= htmlspecialchars($order['address']) ?></p>
            <p><strong>Quantity:</strong> <?= $order['quantity'] ?></p>
            <p><strong>Payment Method:</strong> <?= $order['payment_method'] ?></p>
            <p><strong>Note:</strong> <?= $order['note'] ?></p>
        </div>

        <div class="col-md-7">
            <h5>📦 Product Info</h5>
            <img src="/ecommerce/images/uploads/<?= $order['product_image'] ?>" class="img-fluid mb-2" style="max-height: 200px;">
            <p><strong>Name:</strong> <?= htmlspecialchars($order['product_name']) ?></p>
            <p><strong>Description:</strong> <?= htmlspecialchars($order['product_description']) ?></p>
            <p><strong>Price:</strong> PKR <?= $order['original_price'] ?></p>
            <p><strong>Discount:</strong> <?= $order['discount'] ?>%</p>
            <hr>
            <p><strong>Total:</strong> 
                <span class="text-success">
                    PKR <?= ($order['original_price'] - ($order['original_price'] * $order['discount'] / 100)) * $order['quantity'] ?>
                </span>
            </p>
        </div>
    </div>

    <a href="customer_orders.php" class="btn btn-secondary"> ← Back to Orders</a>
     <a href="../dashboard.php" class="btn btn-secondary"> ← Back to Dashboard </a>
</div>
