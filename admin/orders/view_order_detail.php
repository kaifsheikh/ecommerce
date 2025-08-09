<?php
include "../../config/db.php";
include "../includes/session_check.php";

if (!isset($_GET['id'])) {
    echo "Order ID missing.";
    exit;
}

$order_id = $_GET['id'];

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .order-container {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .order-heading {
            font-weight: bold;
            color: #444;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        .product-img {
            border-radius: 8px;
            max-height: 250px;
            object-fit: cover;
        }
        @media (max-width: 768px) {
            .product-img {
                max-height: 200px;
            }
        }
    </style>
</head>
<body class="bg-light">

<div class="container py-4">
    <div class="order-container">
        <h3 class="mb-4 text-primary">🛒 Order Details <small class="text-muted">(Order #<?= $order['id'] ?>)</small></h3>

        <div class="row g-4">
            <!-- Customer Info -->
            <div class="col-md-5">
                <h5 class="order-heading">🧾 Customer Info</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Name:</strong> <?= htmlspecialchars($order['fullname']) ?></li>
                    <li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($order['email']) ?></li>
                    <li class="list-group-item"><strong>Phone:</strong> <?= htmlspecialchars($order['phone']) ?></li>
                    <li class="list-group-item"><strong>Address:</strong> <?= htmlspecialchars($order['address']) ?></li>
                    <li class="list-group-item"><strong>Quantity:</strong> <?= $order['quantity'] ?></li>
                    <li class="list-group-item"><strong>Payment Method:</strong> <?= $order['payment_method'] ?></li>
                    <li class="list-group-item"><strong>Note:</strong> <?= $order['note'] ?: 'N/A' ?></li>
                </ul>
            </div>

            <!-- Product Info -->
            <div class="col-md-7">
                <h5 class="order-heading">📦 Product Info</h5>
                <div class="card shadow-sm border-0">
                    <img src="/ecommerce/images/uploads/<?= $order['product_image'] ?>" class="card-img-top product-img" style="" alt="Product Image">

                    
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($order['product_name']) ?></h5>
                        <p class="card-text text-muted"><?= htmlspecialchars($order['product_description']) ?></p>
                        <p><strong>Price:</strong> PKR <?= number_format($order['original_price'], 2) ?></p>
                        <p><strong>Discount:</strong> <?= $order['discount'] ?>%</p>
                        <hr>
                        <h5 class="text-success">
                            Total: PKR <?= number_format(($order['original_price'] - ($order['original_price'] * $order['discount'] / 100)) * $order['quantity'], 2) ?>
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="mt-4 d-flex gap-2">
            <a href="customer_orders.php" class="btn btn-secondary">← Back to Orders</a>
            <a href="../dashboard.php" class="btn btn-outline-secondary">← Back to Dashboard</a>
        </div>
    </div>
</div>

</body>
</html>
