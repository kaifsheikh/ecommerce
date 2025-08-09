<?php
include '../../config/db.php';
include '../includes/session_check.php';

// ✅ Agar form submit hua hai (Update Logic)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id     = intval($_POST['id']);
    $name   = mysqli_real_escape_string($conn, $_POST['name']);
    $email  = mysqli_real_escape_string($conn, $_POST['email']);
    $role   = mysqli_real_escape_string($conn, $_POST['role']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    if (empty($name) || empty($email) || empty($role) || empty($status)) {
        die("❌ All fields are required.");
    }

    $query = "UPDATE users 
              SET name='$name', email='$email', role='$role', status='$status'
              WHERE id=$id";

    if (mysqli_query($conn, $query)) {
        header("Location: edit_user.php?id=$id&msg=updated");
        exit;
    } else {
        echo "❌ Error updating record: " . mysqli_error($conn);
    }
}

// ✅ Agar GET request hai to user ka data load karo
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
    } else {
        die("❌ User not found!");
    }
} else {
    die("❌ No user ID provided!");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .edit-card {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="edit-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">✏️ Edit User</h4>
            <a href="./users_manage.php" class="btn btn-secondary btn-sm">← Back</a>
        </div>

        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'updated'): ?>
            <div class="alert alert-success py-2">✅ User updated successfully.</div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="id" value="<?= $user['id'] ?>">

            <div class="mb-3">
                <label class="form-label fw-bold">Full Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Email Address</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Role</label>
                <select name="role" class="form-select" required>
                    <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
                    <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Status</label>
                <select name="status" class="form-select" required>
                    <option value="pending" <?= $user['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="approved" <?= $user['status'] == 'approved' ? 'selected' : '' ?>>Approved</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">💾 Update User</button>
        </form>
    </div>
</div>
</body>
</html>
