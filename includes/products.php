<style>
  /* Desktop styles */
.product-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr); /* 4 columns desktop par */
  gap: 20px;
}

/* Mobile styles */
@media (max-width: 768px) {
  .product-grid {
    grid-template-columns: repeat(2, 1fr); /* mobile pe 2 column */
    gap: 10px; /* kam gap */
  }

  .showcase img {
    width: 100%;  /* images responsive banengi */
    height: auto;
  }

  .showcase {
    padding: 5px;
  }

  .showcase-title {
    font-size: 14px;
  }

  .price-box .price,
  .price-box del {
    font-size: 13px;
  }

  .showcase-rating ion-icon {
    font-size: 14px;
  }
}

</style>
<main>

  <!--
      - PRODUCT
    -->

  <div class="product-container">
    <div class="container">


      <!--
          - Category Section Desktop
        -->
      <div class="sidebar  has-scrollbar" data-mobile-menu>
        <div class="sidebar-category">


          <div class="sidebar-top">
            <h2 class="sidebar-title">Category</h2>

            <button class="sidebar-close-btn" data-mobile-menu-close-btn>
              <ion-icon name="close-outline"></ion-icon>
            </button>
          </div>

          <ul class="sidebar-menu-category-list">

            <li class="sidebar-menu-category">
              <button class="sidebar-accordion-menu" onclick="loadProducts('all')">
                <div class="menu-title-flex">
                  <img src="/ecommerce/images/category/bag.svg" alt="All" width="20" height="20" class="menu-title-img">
                  <p class="menu-title">All Products</p>
                </div>

                <div>
                  <ion-icon name="add-outline" class="add-icon"></ion-icon>
                  <ion-icon name="remove-outline" class="remove-icon"></ion-icon>
                </div>
              </button>
            </li>

            <?php
            // Get distinct categories
            $category_sql = "SELECT DISTINCT category FROM products";
            $category_result = mysqli_query($conn, $category_sql);
            ?>

            <?php while ($cat = mysqli_fetch_assoc($category_result)): ?>
              <li class="sidebar-menu-category">

                <button class="sidebar-accordion-menu" onclick="loadProducts('<?php echo addslashes($cat['category']); ?>')" data-accordion-btn>

                  <div class="menu-title-flex">
                    <img src="/ecommerce/images/category/bag.svg" alt="<?php echo htmlspecialchars($cat['category']); ?>" width="20" height="20" class="menu-title-img">
                    <p class="menu-title"><?php echo htmlspecialchars($cat['category']); ?></p>
                  </div>

                  <div>
                    <ion-icon name="add-outline" class="add-icon"></ion-icon>
                    <ion-icon name="remove-outline" class="remove-icon"></ion-icon>
                  </div>
                </button>

                <ul class="sidebar-submenu-category-list" data-accordion>

                  <?php
                  // Get all products of this category
                  $sub_sql = "SELECT name, id FROM products WHERE category = '" . mysqli_real_escape_string($conn, $cat['category']) . "'";
                  $sub_result = mysqli_query($conn, $sub_sql);
                  ?>

                  <?php while ($sub = mysqli_fetch_assoc($sub_result)): ?>
                    <li class="sidebar-submenu-category">
                      <a href="product-details.php?id=<?php echo $sub['id']; ?>" class="sidebar-submenu-title">
                        <p class="product-name"><?php echo htmlspecialchars($sub['name']); ?></p>
                        <!-- Optional: Stock or something else -->
                      </a>
                    </li>
                  <?php endwhile; ?>

                </ul>

              </li>
            <?php endwhile; ?>

          </ul>
        </div>
      </div>



      <!-- New Products Section -->
      <div class="product-box" id="product-list">
        <?php
        $query = "SELECT * FROM products ORDER BY id DESC";
        $result = mysqli_query($conn, $query);
        ?>

        <div class="product-main">
          <h2 class="title">New Products</h2>

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

                  <a href="#">
                    <h3 class="showcase-title"><?= htmlspecialchars($row['name']) ?></h3>
                  </a>

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