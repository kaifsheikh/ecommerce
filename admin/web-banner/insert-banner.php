<?php
include("../../config/db.php");

// File upload
$imagePath = '';
if (!empty($_FILES['image']['name'])) {
    $targetDir = "../../images/uploads/";
    $imageName = time() . "_" . basename($_FILES["image"]["name"]);
    $imagePath = $targetDir . $imageName;

    // Validate file type (optional)
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    if (!in_array($_FILES['image']['type'], $allowedTypes)) {
        die("Invalid file type.");
    }

    // Move uploaded file
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
        die("Image upload failed.");
    }
}

// Prepare path for DB (public path)
$imageDBPath = "/ecommerce/images/uploads/" . $imageName;

// Escape user inputs
$title = mysqli_real_escape_string($conn, $_POST['title']);
$subtitle = mysqli_real_escape_string($conn, $_POST['subtitle']);
$text = mysqli_real_escape_string($conn, $_POST['text']);
$price = mysqli_real_escape_string($conn, $_POST['price']);

// Insert into DB
$query = "INSERT INTO banners (image, subtitle, title, text, price, status)
          VALUES ('$imageDBPath', '$subtitle', '$title', '$text', '$price', 'active')";

if (mysqli_query($conn, $query)) {
    echo "Banner added successfully.<br>";
    echo '<a href="view-banners.php">View Banners</a>';
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
