<?php
include "../../config/db.php";
include "../includes/session_check.php"; // Session Check

// Fetch all products
$query = "SELECT * FROM products ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .table td, .table th {
        vertical-align: middle;
    }
    /* Mobile Friendly Table -> Cards */
    @media (max-width: 768px) {
        table thead {
            display: none;
        }
        table tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            padding: 10px;
        }
        table tbody td {
            display: flex;
            justify-content: space-between;
            padding: 8px;
            border: none !important;
        }
        table tbody td::before {
            content: attr(data-label);
            font-weight: bold;
            color: #0d6efd;
        }
        img {
            max-width: 100px;
            height: auto;
        }
        .btn {
            padding: 6px 8px;
            font-size: 0.8rem;
        }
    }
</style>
</head>

<div class="container mt-4">
    <!-- Heading + Back Button -->
    <div class="position-relative mb-4 text-center">
        <h2 class="mb-0 text-primary fw-bold">📦 All Products</h2>
        <a href="../dashboard.php" 
           class="btn btn-danger shadow-sm position-absolute top-0 end-0">
            ← Back
        </a>
    </div>

    <!-- Table -->
    <div class="card shadow-lg border-0">
        <div class="card-body p-3">
            <div class="table-responsive shadow-sm rounded">
                <table class="table table-hover align-middle text-center mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>Image 1</th>
                            <th>Image 2</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr class="shadow-sm">
                                <td data-label="ID"><?= $row['id'] ?></td>
                                <td data-label="Name"><?= htmlspecialchars($row['name']) ?></td>
                                <td data-label="Category"><?= htmlspecialchars($row['category']) ?></td>
                                <td data-label="Description" style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <?= htmlspecialchars($row['description']) ?>
                                </td>
                                <td data-label="Price">Rs. <?= number_format($row['price'], 2) ?></td>
                                <td data-label="Discount"><?= $row['discount'] ?>%</td>
                                <td data-label="Image 1">
                                    <img src="/ecommerce/images/uploads/<?= $row['image1'] ?>" 
                                         class="img-thumbnail shadow-sm" style="max-width: 80px;">
                                </td>
                                <td data-label="Image 2">
                                    <img src="/ecommerce/images/uploads/<?= $row['image2'] ?>" 
                                         class="img-thumbnail shadow-sm" style="max-width: 80px;">
                                </td>
                                <td data-label="Actions">
                                    <a href="product_update.php?id=<?= $row['id'] ?>" 
                                       class="btn btn-sm btn-primary me-1 shadow-sm">
                                        ✏ Edit
                                    </a>
                                    <a href="product_delete.php?id=<?= $row['id'] ?>" 
                                       class="btn btn-sm btn-danger shadow-sm"
                                       onclick="return confirm('Are you sure you want to delete this product?')">
                                        🗑 Delete
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
