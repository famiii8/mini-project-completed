<?php
session_start(); // Start the session

$conn = mysqli_connect("localhost", "root", "", "ration");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Assuming user ID is stored in session
$user_id = $_SESSION['user_id'];

$user_query = "SELECT card_color FROM users WHERE usid = '$user_id'";
$user_result = mysqli_query($conn, $user_query);

if ($user_result && mysqli_num_rows($user_result) > 0) {
    $user = mysqli_fetch_assoc($user_result);
    $card_id = $user['card_color'];

    $card_query = "SELECT * FROM cards WHERE card_type = '$card_id'";
    $card_result = mysqli_query($conn, $card_query);
    $card = mysqli_fetch_assoc($card_result);
} else {
    echo "<p>User not found or card details unavailable.</p>";
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="userdash.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-title">E-RATION MANAGEMENT SYSTEM</div>
        <ul class="nav-menu">
            <li><a href="book_supplies.php">Book Supplies</a></li>
            <li><a href="slot_details.php">Order Details</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <h1>Dashboard</h1>
    
    <?php if (isset($card) && $card): ?>
        <h2>Available Supplies for your Card</h2>
        <table border="1">
            <tr>
                <th>Card Type</th>
                <th>Available Rice</th>
                <th>Price</th>
                <th>Available Wheat</th>
                <th>Price</th>
                <th>Available Atta</th>
                <th>Price</th>
            </tr>
            <tr>
                <td><?php echo $card['card_type']; ?></td>
                <td><?php echo $card['rice']; ?> Kg</td>
                <td>Rs. <?php echo $card['rice_price']; ?></td>
                <td><?php echo $card['wheat']; ?> Kg</td>
                <td>Rs. <?php echo $card['wheat_price']; ?></td>
                <td><?php echo $card['atta']; ?> Packets</td>
                <td>Rs. <?php echo $card['atta_price']; ?></td>
            </tr>
        </table>
    <?php else: ?>
        <p>No card details found for this user.</p>
    <?php endif; ?>
</body>
</html>
