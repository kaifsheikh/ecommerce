<?php
include '../config/db.php';

$category = $_GET['category'] ?? '';
$category_safe = mysqli_real_escape_string($conn, $category);

// Check if "all" is selected
if ($category_safe === 'all') {
  $query = "SELECT * FROM products ORDER BY id DESC";
} else {
  $query = "SELECT * FROM products WHERE category = '$category_safe' ORDER BY id DESC";
}

$result = mysqli_query($conn, $query);
?>

<div class="product-main">
  <h2 class="title"><?= $category_safe === 'all' ? 'All Products' : htmlspecialchars($category_safe) . ' Products' ?></h2>

  <div class="product-grid">

    <?php while ($row = mysqli_fetch_assoc($result)): ?>
      <div class="showcase">
        <div class="showcase-banner">
          <a href="./product-detail/index.php?id=<?= $row['id'] ?>">
            <img src="/ecommerce/images/uploads/<?= $row['image1'] ?>" alt="<?= $row['name'] ?>" width="300" class="product-img default">
            <img src="/ecommerce/images/uploads/<?= $row['image2'] ?>" alt="<?= $row['name'] ?>" width="300" class="product-img hover">
          </a>

          <p class="showcase-badge"><?= $row['discount'] ?>%</p>

          <div class="showcase-actions">
            <button class="btn-action"><ion-icon name="heart-outline"></ion-icon></button>

            <a href="./product-detail/index.php?id=<?= $row['id'] ?>">
              <button class="btn-action"><ion-icon name="eye-outline"></ion-icon></button>
            </a>

            <button class="btn-action"><ion-icon name="bag-add-outline"></ion-icon></button>
          </div>
        </div>

        <div class="showcase-content">
          <a href="#" class="showcase-category"><?= htmlspecialchars($row['category']) ?></a>
          <a href="#"><h3 class="showcase-title"><?= htmlspecialchars($row['name']) ?></h3></a>

          <div class="showcase-rating">
            <?php for ($i = 1; $i <= 5; $i++): ?>
              <ion-icon name="<?= $i <= $row['rating'] ? 'star' : 'star-outline' ?>"></ion-icon>
            <?php endfor; ?>
          </div>

          <div class="price-box">
            <p class="price">PKR <?= $row['price'] ?></p>
            <del>PKR <?= number_format($row['price'] + ($row['price'] * $row['discount'] / 100)) ?></del>
          </div>
        </div>
      </div>
    <?php endwhile; ?>

  </div>
</div>
