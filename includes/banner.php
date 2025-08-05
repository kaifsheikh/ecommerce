<main>

<?php
// include("./config/db.php");
$query = "SELECT * FROM banners WHERE status = 'active'";
$result = mysqli_query($conn, $query);
?>

<div class="banner">
  <div class="container">
    <div class="slider-container has-scrollbar">

      <?php while ($row = mysqli_fetch_assoc($result)) { ?>

        <div class="slider-item">
          <img src="<?php echo $row['image']; ?>" class="banner-img" alt="banner">
          <div class="banner-content">
            <p class="banner-subtitle"><?php echo $row['subtitle']; ?></p>
            <h2 class="banner-title"><?php echo $row['title']; ?></h2>
            <p class="banner-text">starting at &dollar; <b><?php echo $row['price']; ?></b></p>
            <a href="#" class="banner-btn">Shop now</a>
          </div>
        </div>
      <?php } ?>

    </div>
  </div>
</div>