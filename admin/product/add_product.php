<?php
include "../../config/db.php"; // Adjust path if needed
include "../includes/session_check.php"; // Session Check

$success = "";
$error = "";

if (isset($_POST['add'])) {
    // Basic validation
    if (
        empty($_POST['name']) || empty($_POST['category']) || empty($_POST['description']) ||
        empty($_POST['price']) || empty($_POST['discount']) ||
        empty($_FILES['image1']['name']) || empty($_FILES['image2']['name'])
    ) {
        $error = "Please fill in all fields and upload both images.";
    } else {
        // Sanitize data
        $name     = mysqli_real_escape_string($conn, $_POST['name']);
        $category = mysqli_real_escape_string($conn, $_POST['category']);
        $desc     = mysqli_real_escape_string($conn, $_POST['description']);
        $price    = $_POST['price'];
        $discount = $_POST['discount'];

        $img1 = $_FILES['image1']['name'];
        $img2 = $_FILES['image2']['name'];

        $tmp1 = $_FILES['image1']['tmp_name'];
        $tmp2 = $_FILES['image2']['tmp_name'];


        $uploadPath1 = $_SERVER['DOCUMENT_ROOT'] . "/ecommerce/images/uploads/" . $img1;
        $uploadPath2 = $_SERVER['DOCUMENT_ROOT'] . "/ecommerce/images/uploads/" . $img2;


        // $uploadPath1 = "../../assets/images/products/$img1";
        // $uploadPath2 = "../../assets/images/products/$img2";


        if (move_uploaded_file($tmp1, $uploadPath1) && move_uploaded_file($tmp2, $uploadPath2)) {
            $sql = "INSERT INTO products (name, category, description, price, discount, image1, image2) 
                    VALUES ('$name', '$category', '$desc', '$price', '$discount', '$img1', '$img2')";

            if (mysqli_query($conn, $sql)) {
                $success = "Product added successfully!";
            } else {
                $error = "Database error: " . mysqli_error($conn);
            }
        } else {
            $error = "Failed to upload images.";
        }
    }
}
?>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Make form wider on large screens */
        @media (min-width: 992px) {
            .form-container {
                max-width: 800px;
                margin: auto;
            }
        }

        /* Mobile adjustments */
        @media (max-width: 576px) {
            .form-container {
                padding: 15px;
            }

            .form-container input,
            .form-container textarea,
            .form-container select {
                font-size: 14px;
            }
        }
    </style>
</head>

<div class="container my-5">
    <div class="form-container p-4 border rounded shadow-lg bg-white">

        <!-- Back Button + Heading -->
        <div class="position-relative mb-3 text-center">
            <h4 class="mb-0 text-primary">Add Product</h4>
            <a href="../dashboard.php"
                class="btn btn-outline-secondary btn-sm position-absolute top-0 end-0">
                ← Back
            </a>
        </div>

        <!-- Success -->
        <?php if ($success): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $success ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Error -->
        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $error ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label fw-semibold">Product Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter product name" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Category</label>
                <input type="text" name="category" class="form-control" placeholder="Enter category" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Enter product description"></textarea>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Price (Rs.)</label>
                    <input type="number" step="0.01" name="price" class="form-control" placeholder="Enter price" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Discount (%)</label>
                    <input type="number" step="0.01" name="discount" class="form-control" placeholder="Enter discount" required>
                </div>
            </div>

            <div class="mb-3 mt-3">
                <label class="form-label fw-semibold">Product Image 1</label>
                <input type="file" name="image1" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Product Image 2</label>
                <input type="file" name="image2" class="form-control" required>
            </div>

            <button type="submit" name="add" class="btn btn-primary w-100 py-2 fw-bold">
                ➕ Add Product
            </button>
        </form>
    </div>
</div>