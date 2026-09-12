<?php
require "config.php";

// Delete a property if requested
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM properties WHERE id = $id");
    header("Location: index.php");
    exit;
}

$result = $conn->query("SELECT * FROM properties ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SAFE-RENT</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>SAFE-RENT</h1>
        <p class="subtitle">Rental property management</p>

        <a href="add_property.php" class="btn">+ Add Property</a>

        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Address</th>
                    <th>Rent (MAD)</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['address']) ?></td>
                    <td><?= number_format($row['monthly_rent'], 2) ?></td>
                    <td><span class="status <?= $row['status'] ?>"><?= $row['status'] ?></span></td>
                    <td>
                        <a href="index.php?delete=<?= $row['id'] ?>" class="delete-link"
                           onclick="return confirm('Delete this property?');">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>

                <?php if ($result->num_rows === 0): ?>
                <tr><td colspan="5" class="empty">No properties yet. Add one above.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
