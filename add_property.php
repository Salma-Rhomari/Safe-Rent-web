<?php
require "config.php";

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $address = trim($_POST['address']);
    $rent = floatval($_POST['monthly_rent']);

    if ($title === "" || $address === "" || $rent <= 0) {
        $error = "Please fill all fields correctly.";
    } else {
        $stmt = $conn->prepare("INSERT INTO properties (title, address, monthly_rent) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $title, $address, $rent);
        $stmt->execute();
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Property - SAFE-RENT</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Add a Property</h1>

        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" class="form">
            <label>Title</label>
            <input type="text" name="title" placeholder="e.g. Apartment in Agdal" required>

            <label>Address</label>
            <input type="text" name="address" placeholder="e.g. Rue X, Rabat" required>

            <label>Monthly Rent (MAD)</label>
            <input type="number" step="0.01" name="monthly_rent" placeholder="e.g. 3500" required>

            <button type="submit" class="btn">Save</button>
        </form>

        <a href="index.php" class="back-link">&larr; Back to list</a>
    </div>
</body>
</html>
