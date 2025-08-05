<?php
include '../../config/db.php';
include '../includes/session_check.php';

// ✅ Get user ID from query string
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("User ID is missing.");
}

$user_id = $_GET['id'];

// ✅ Fetch user data from DB
$query = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    die("User not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>✏️ Edit Users</h2>
        <a href="../dashboard.php" class="btn btn-secondary">← Back to User List</a>
    </div>

    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'updated'): ?>
        <div class="alert alert-success">✅ User updated successfully.</div>
    <?php endif; ?>

    <form action="update_user.php" method="post" class="border p-4 rounded bg-light shadow-sm">
        <input type="hidden" name="id" value="<?= $user['id'] ?>">

        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-select" required>
                <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
                <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="pending" <?= $user['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                <option value="approved" <?= $user['status'] == 'approved' ? 'selected' : '' ?>>Approved</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">💾 Update User</button>
    </form>
</div>
</body>
</html>
