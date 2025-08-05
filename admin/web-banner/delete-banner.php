<?php
include("../../config/db.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get banner info from DB
    $getQuery = "SELECT image FROM banners WHERE id = $id";
    $getResult = mysqli_query($conn, $getQuery);
    $row = mysqli_fetch_assoc($getResult);

    if ($row) {
        // Convert DB path to real path
        $imagePath = "../../images/uploads/" . ltrim($row['image'], '/');

        // Delete image file from folder
        if (file_exists($imagePath)) {
            unlink($imagePath);
        } else {
            echo "Image not found at: $imagePath";
        }

        // Delete from database
        $deleteQuery = "DELETE FROM banners WHERE id = $id";
        if (mysqli_query($conn, $deleteQuery)) {
            header("Location: view-banners.php?deleted=1");
            exit;
        } else {
            echo "Failed to delete banner from database.";
        }
    } else {
        echo "Banner not found.";
    }
} else {
    echo "Invalid request.";
}
?>
