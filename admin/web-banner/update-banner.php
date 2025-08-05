<?php
include "../../config/db.php";
include "../includes/session_check.php"; // Session Check

// Show error messages
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<h2>Add New Banner</h2>

<form action="insert-banner.php" method="post" enctype="multipart/form-data">
  <label>Title:</label><br>
  <input type="text" name="title" required><br><br>

  <label>Subtitle:</label><br>
  <input type="text" name="subtitle" required><br><br>

  <label>Text:</label><br>
  <input type="text" name="text" required><br><br>

  <label>Price:</label><br>
  <input type="number" step="0.01" name="price" required><br><br>

  <label>Image:</label><br>
  <input type="file" name="image" accept="image/*" required><br><br>

  <input type="submit" value="Add Banner">
</form>

