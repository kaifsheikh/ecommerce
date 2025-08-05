<?php
include "../../config/db.php";
include "../includes/session_check.php"; // Session Check

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete product
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");

    // Redirect back to products list
    header("Location: manage_product.php");
    exit;
}
?>
