<?php
include "../../config/db.php";
include "../includes/session_check.php"; // Session Check


// Fetch all products
$query = "SELECT * FROM products ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container">
    <div class="row">
        <div class="col">
            <h2 class="mb-4 text-center shadow p-3 mt-1 rounded">All Products</h2>
            <a href="../dashboard.php" class="btn btn-danger">Back</a>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
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
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['category']) ?></td>
                                <td><?= htmlspecialchars($row['description']) ?></td>
                                <td>Rs. <?= number_format($row['price'], 2) ?></td>
                                <td><?= $row['discount'] ?>%</td>

                                <td>
                                    <img src="/ecommerce/images/uploads/<?= $row['image1'] ?>" class="img-thumbnail" width="80">
                                </td>

                                <td>
                                    <img src="/ecommerce/images/uploads/<?= $row['image2'] ?>" class="img-thumbnail" width="80">
                                </td>
                                
                                <td>
                                    <a href="product_update.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary mb-1">Edit</a>

                                    <a href="product_delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>