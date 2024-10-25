<?php
session_start(); // Start the session

$conn = mysqli_connect("localhost", "root", "", "ration");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Assuming user ID is stored in session
$user_id = $_SESSION['user_id'];

// Fetch the user's pin code
$user_query = "SELECT pincode FROM users WHERE usid = '$user_id'";
$user_result = mysqli_query($conn, $user_query);

if ($user_result && mysqli_num_rows($user_result) > 0) {
    $user = mysqli_fetch_assoc($user_result);
    $user_pin_code = $user['pincode'];

    // Fetch shops available in the same pin code
    $shop_query = "SELECT * FROM shops WHERE pincode = '$user_pin_code'";
    $shop_result = mysqli_query($conn, $shop_query);
} else {
    echo "<p>User not found or unable to retrieve pin code.</p>";
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Supplies</title>
    <link rel="stylesheet" href="userdash.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-title">E-RATION MANAGEMENT SYSTEM</div>
        <ul class="nav-menu">
            <li><a href="userdash.php">Dashboard</a></li>
            <li><a href="book_supplies.php">Book Supplies</a></li>
            <li><a href="order_details.php">Order Details</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <h1>Book Supplies</h1>

    <?php if (isset($shop_result) && mysqli_num_rows($shop_result) > 0): ?>
        <h2>Available Shops</h2>
        <table border="1">
            <tr>
                <th>Shop Name</th>
                <th>Address</th>
                <th>Shop owner</th>
                <th>Action</th>
            </tr>
            <?php while ($shop = mysqli_fetch_assoc($shop_result)): ?>
            <tr>
                <td><?php echo $shop['shop_name']; ?></td>
                <td><?php echo $shop['address']; ?></td>
                <td><?php echo $shop['shop_owner']; ?></td>
                <td><a href="shop_detail.php?shop_id=<?php echo $shop['id']; ?>">Book Supplies</a></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No shops available in your area.</p>
    <?php endif; ?>
</body>
</html>
