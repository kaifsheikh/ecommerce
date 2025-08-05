<?php
include("../../config/db.php");

$query = "SELECT * FROM banners";
$result = mysqli_query($conn, $query);
?>

<h2>All Banners</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Image</th>
        <th>Title</th>
        <th>Subtitle</th>
        <th>Price</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><img src="<?php echo $row['image']; ?>" width="200"></td>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['subtitle']; ?></td>
            <td>$<?php echo $row['price']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td>
                <!-- Toggle Status -->
                <?php if ($row['status'] === 'active') { ?>
                    <a href="toggle-status.php?id=<?php echo $row['id']; ?>&status=inactive">Deactivate</a>
                <?php } else { ?>
                    <a href="toggle-status.php?id=<?php echo $row['id']; ?>&status=active">Activate</a>
                <?php } ?>

                | <a href="edit-banner.php?id=<?php echo $row['id']; ?>">Edit</a>
                | <a href="delete-banner.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
    <?php } ?>
</table>
