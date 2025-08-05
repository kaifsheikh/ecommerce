<?php
include "../../config/db.php";
include "../includes/session_check.php"; // Session Check

if (!isset($_GET['id']) || !isset($_GET['status'])) {
    die("Missing parameters.");
}

$id = (int) $_GET['id'];
$status = $_GET['status'];

if (!in_array($status, ['approved', 'rejected'])) {
    die("Invalid status.");
}

$query = "UPDATE orders SET status = '$status' WHERE id = $id";
if (mysqli_query($conn, $query)) {
    header("Location: customer_orders.php");
    exit;
} else {
    die("Failed to update order.");
}
