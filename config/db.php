<?php

// Start the session (optional, for future use)
session_start();

// Connect to database
$conn = mysqli_connect("localhost", "root", "", "ecommerce");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>