<main>

  <!--
      - CATEGORY
    -->
  <div class="category">
    <div class="container">
      <div class="category-item-container has-scrollbar">

        <!-- Static Category Show All Product -->
        <div class="category-item">
          <div class="category-img-box">
            <img src="/ecommerce/images/category/bag.svg" alt="All Products" width="30">
          </div>

          <div class="category-content-box">
            <div class="category-content-flex">
              <h3 class="category-item-title">All Products</h3>
            </div>
            <a href="javascript:void(0);" class="category-btn" onclick="loadProducts('all')">Show all</a>
          </div>
        </div>


        
        <?php
        $query = "SELECT DISTINCT category FROM products";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)):
        ?>

          <!-- Dynamic Category -->
          <div class="category-item">

            <div class="category-img-box">
              <img src="/ecommerce/images/category/bag.svg" alt="<?php echo htmlspecialchars($row['category']); ?>" width="30">
            </div>

            <div class="category-content-box">

              <div class="category-content-flex">
                <h3 class="category-item-title"><?php echo htmlspecialchars($row['category']); ?></h3>

                <p class="category-item-amount">(53)</p>
              </div>

              <a href="javascript:void(0);" class="category-btn" onclick="loadProducts('<?php echo addslashes($row['category']); ?>')">Show all</a>

            </div>

          </div>

        <?php endwhile; ?>

      </div>
    </div>
  </div>
