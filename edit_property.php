<?php
require "config.php";

$error = "";
$id = intval($_GET['id'] ?? 0);

// Load existing property
$stmt = $conn->prepare("SELECT * FROM properties WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$property = $result->fetch_assoc();

if (!$property) {
    die("Property not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $address = trim($_POST['address']);
    $rent = floatval($_POST['monthly_rent']);
    $status = $_POST['status'];

    if ($title === "" || $address === "" || $rent <= 0) {
        $error = "Please fill all fields correctly.";
    } else {
        $update = $conn->prepare("UPDATE properties SET title=?, address=?, monthly_rent=?, status=? WHERE id=?");
        $update->bind_param("ssdsi", $title, $address, $rent, $status, $id);
        $update->execute();
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Property - SAFE-RENT</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Property</h1>

        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" class="form">
            <label>Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($property['title']) ?>" required>

            <label>Address</label>
            <input type="text" name="address" value="<?= htmlspecialchars($property['address']) ?>" required>

            <label>Monthly Rent (MAD)</label>
            <input type="number" step="0.01" name="monthly_rent" value="<?= $property['monthly_rent'] ?>" required>

            <label>Status</label>
            <select name="status">
                <option value="available" <?= $property['status'] === 'available' ? 'selected' : '' ?>>Available</option>
                <option value="rented" <?= $property['status'] === 'rented' ? 'selected' : '' ?>>Rented</option>
            </select>

            <button type="submit" class="btn">Save Changes</button>
        </form>

        <a href="index.php" class="back-link">&larr; Back to list</a>
    </div>
</body>
</html>