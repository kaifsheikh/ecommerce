<?php
include "../../config/db.php";
include "../includes/session_check.php";

// DELETE logic
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $del = "DELETE FROM users WHERE id = $delete_id";
    if (mysqli_query($conn, $del)) {
        header("Location: manage_users.php?msg=deleted");
        exit;
    }
}

// Fetch approved users
$sql = "SELECT * FROM users WHERE status = 'approved'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Approved Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">✅ Manage Approved Users</h3>
        <a href="../dashboard.php" class="btn btn-outline-secondary">← Back to Dashboard</a>
    </div>

    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
        <div class="alert alert-success">User deleted successfully.</div>
    <?php endif; ?>

    <div class="card p-3">
        <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>👤 Name</th>
                        <th>📧 Email</th>
                        <th>🕒 Registered At</th>
                        <th>🟢 Status</th>
                        <th>⚙️ Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 1; while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td>
                        <span class="badge bg-<?= $row['status'] === 'approved' ? 'success' : 'warning' ?>">
                            <?= ucfirst($row['status']) ?>
                        </span>
                    </td>
                    <td>
                        <a href="edit_user.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">✏️ Edit</a>
                            
                       <a href="delete_user.php?id=<?= $row['id'] ?>" 
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Are you sure you want to delete this user?');">
                        🗑 Delete
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
            <div class="alert alert-info">No approved users found.</div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
