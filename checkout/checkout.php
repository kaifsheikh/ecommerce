<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Responsive Checkout</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .checkout-container {
            max-width: 850px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .form-label {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 4px;
        }

        .form-control,
        .form-select {
            font-size: 14px;
            padding: 8px 10px;
        }

        .summary-img {
            width: 100%;
            height: auto;
            max-height: 200px;
            object-fit: contain;
            border-radius: 6px;
        }

        .list-group-item {
            padding: 8px 12px;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .checkout-container {
                padding: 15px;
            }
        }
    </style>
</head>

<body>

    <?php
    include "../config/db.php";
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        die("Product ID is missing.");
    }
    $product_id = $_GET['id'];
    $query = "SELECT * FROM products WHERE id = $product_id";
    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_assoc($result);
    $unit_price = $product['price'] - ($product['price'] * $product['discount'] / 100);
    ?>

    <div class="container checkout-container">
        <form action="place_order.php" method="post" class="needs-validation" novalidate>
            <input type="hidden" name="product_id" value="<?= $product_id ?>">
            <input type="hidden" id="unitPrice" value="<?= $unit_price ?>">
            <input type="hidden" id="priceField" name="price" value="<?= $unit_price ?>">

            <div class="row g-3">
                <!-- Product Summary -->
                <div class="col-lg-4 col-md-5">
                    <h5 class="text-primary">Product Summary</h5>
                    <ul class="list-group mb-2">
                        <li class="list-group-item d-flex justify-content-between">
                            <span><?= htmlspecialchars($product['name']) ?></span>
                            <strong>PKR <?= $unit_price ?></strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Discount</span>
                            <small class="text-success">−<?= ($product['price'] * $product['discount'] / 100) ?> PKR</small>
                        </li>
                        <li class="list-group-item d-flex justify-content-between bg-light">
                            <strong>Total</strong>
                            <strong id="totalPrice">PKR <?= $unit_price ?></strong>
                        </li>
                    </ul>
                    <img src="/ecommerce/images/uploads/<?= $product['image1'] ?>" class="summary-img" alt="product image">
                </div>

                <!-- Billing Form -->
                <div class="col-lg-8 col-md-7">
                    <h5 class="text-success mb-3">Customer Details</h5>
                    <div class="row g-2">
                        <div class="col-12">
                            <label for="fullname" class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="fullname" id="fullname" required>
                        </div>
                        <div class="col-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                        <div class="col-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone" id="phone" required>
                        </div>
                        <div class="col-12">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" name="address" id="address" rows="2" required></textarea>
                        </div>
                        <div class="col-6">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" name="quantity" id="quantity" value="1" min="1" required>
                        </div>
                        <div class="col-6">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select class="form-select" name="payment_method" id="payment_method" required>
                                <option value="">Choose...</option>
                                <option value="Cash on Delivery">Cash on Delivery</option>
                                <option value="EasyPaisa">EasyPaisa</option>
                                <option value="JazzCash">JazzCash</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="note" class="form-label">Delivery Note (optional)</label>
                            <input type="text" class="form-control" name="note" id="note" placeholder="e.g. Leave at gate">
                        </div>
                    </div>

                    <!-- <div class="mt-3">
                        <button type="submit" class="btn btn-success w-100">Place Order</button>
                    </div> -->
                    <div class="mt-3 d-flex gap-2">
                        <button type="submit" class="btn btn-success w-100">Place Order</button>
                        <a href="javascript:history.back()" class="btn btn-outline-secondary w-100">← Back</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- JavaScript -->
    <script>
        const quantityInput = document.getElementById("quantity");
        const totalPrice = document.getElementById("totalPrice");
        const unitPrice = parseFloat(document.getElementById("unitPrice").value);
        const priceField = document.getElementById("priceField");

        quantityInput.addEventListener("input", function() {
            let qty = parseInt(this.value);
            if (isNaN(qty) || qty < 1) qty = 1;
            const total = qty * unitPrice;
            totalPrice.textContent = "PKR " + total.toFixed();
            priceField.value = total.toFixed();
        });

        (function() {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated');
                }, false)
            });
        })();
    </script>

</body>

</html>