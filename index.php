<?php include "./config/db.php"; ?>

<?php include "./includes/top-bar.php"; ?>

<?php include "./includes/header.php"; ?>

<?php include "./includes/banner.php"; ?>

<?php include "./includes/category.php"; ?>

<?php include "./includes/products.php"; ?>

<?php include "./includes/product-featured.php"; ?>

<?php include "./includes/footer.php"; ?>


<!-- Login Alert -->
<?php if (!isset($_SESSION['user_id'])): ?>
<script>
  setTimeout(function() {
    Swal.fire({
     title: 'Login Required!',
      text: 'You must login to continue using this website.',
      icon: 'warning',
      confirmButtonText: 'Login Now',
      showCancelButton: false, // ❌ No cancel button
      allowOutsideClick: false, // ⛔ No click outside
      allowEscapeKey: false,    // ⛔ No Esc key
      allowEnterKey: false      // ⛔ No Enter key to bypass

    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = './users/login.php';
      }
    });
  }, 40000); // 40 seconds
</script>
<?php endif; ?>
