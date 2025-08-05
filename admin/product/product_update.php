<?php
include "../../config/db.php";
include "../includes/session_check.php"; // Session Check

if (!isset($_GET['id'])) {
    header("Location: manage_product.php");
    exit;
}

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
$product = mysqli_fetch_assoc($query);

if (isset($_POST['update'])) {
    $name     = $_POST['name'];
    $category = $_POST['category'];
    $desc     = $_POST['description'];
    $price    = $_POST['price'];
    $discount = $_POST['discount'];

    // Handle image1
    if (!empty($_FILES['image1']['name'])) {
        $img1 = $_FILES['image1']['name'];
        $tmp1 = $_FILES['image1']['tmp_name'];
        move_uploaded_file($tmp1, "../../assets/images/products/$img1");
    } else {
        $img1 = $product['image1']; // keep old image
    }

    // Handle image2
    if (!empty($_FILES['image2']['name'])) {
        $img2 = $_FILES['image2']['name'];
        $tmp2 = $_FILES['image2']['tmp_name'];
        move_uploaded_file($tmp2, "../../assets/images/products/$img2");
    } else {
        $img2 = $product['image2']; // keep old image
    }

    // Update query
    mysqli_query($conn, "UPDATE products SET 
        name = '$name', 
        category = '$category', 
        description = '$desc',
        price = '$price', 
        discount = '$discount',
        image1 = '$img1',
        image2 = '$img2'
        WHERE id = $id");

    header("Location: manage_product.php");
    exit;
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container">
    <div class="row">
        <div class="col">
            <h2 class="mb-4 shadow text-center p-3">Edit Product</h2>

            <form method="post" enctype="multipart/form-data" class="row g-3 shadow ">
                <div class="col-md-6">
                    <label class="form-label">Product Name</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Category</label>
                    <input type="text" name="category" value="<?= htmlspecialchars($product['category']) ?>" class="form-control" required>
                </div>

                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($product['description']) ?></textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Price</label>
                    <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Discount (%)</label>
                    <input type="number" step="0.01" name="discount" value="<?= $product['discount'] ?>" class="form-control" required>
                </div>

                <!-- Image 1 -->
                <div class="col-md-6">
                    <label class="form-label">Current Image 1</label><br>
                    <img src="../../assets/images/products/<?= $product['image1'] ?>" class="img-thumbnail mb-2" width="150">
                    <input type="file" name="image1" class="form-control">
                </div>

                <!-- Image 2 -->
                <div class="col-md-6">
                    <label class="form-label">Current Image 2</label><br>
                    <img src="../../assets/images/products/<?= $product['image2'] ?>" class="img-thumbnail mb-2" width="150">
                    <input type="file" name="image2" class="form-control">
                </div>

                <div class="col-12">
                    <button type="submit" name="update" class="btn btn-primary">Update Product</button>
                </div>
            </form>

        </div>
    </div>
</div>