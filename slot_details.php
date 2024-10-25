<?php
session_start();

// Database connection
$con = mysqli_connect("localhost", "root", "", "ration");

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$user_id = $_SESSION['user_id'];

// Fetching booking details, including rice, wheat, and atta quantities
$query = "SELECT booking_date, time_slot, status, rice_quantity, wheat_quantity, atta_quantity FROM bookings WHERE user_id = $user_id";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Booking Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .navbar {
            background-color: #333;
            color: white;
            padding: 10px;
        }
        .navbar-title {
            font-size: 20px;
            margin-bottom: 10px;
        }
        .nav-menu {
            list-style: none;
            padding: 0;
        }
        .nav-menu li {
            display: inline;
            margin: 0 15px;
        }
        .nav-menu a {
            color: white;
            text-decoration: none;
            padding: 5px 10px;
        }
        .nav-menu a:hover {
            background-color: #575757; /* Darker gray on hover */
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<nav class="navbar">
    <div class="navbar-title">E-RATION MANAGEMENT SYSTEM</div>
    <ul class="nav-menu">
        <li><a href="userdash.php">Dashboard</a></li>
        <li><a href="book_supplies.php">Book Supplies</a></li>
        <li><a href="slot_details.php">Slot Details</a></li>
        <li><a href="profile.php">Profile</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav> 
<h1>Your Booking Details</h1>

<?php if ($result && mysqli_num_rows($result) > 0): ?>
    <table>
        <tr>
            <th>Slot Date</th>
            <th>Slot Time</th>
            <th>Status</th>
            <th>Rice Quantity</th>
            <th>Wheat Quantity</th>
            <th>Atta Quantity</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
                <td><?php echo htmlspecialchars($row['time_slot']); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td><?php echo htmlspecialchars($row['rice_quantity']); ?></td>
                <td><?php echo htmlspecialchars($row['wheat_quantity']); ?></td>
                <td><?php echo htmlspecialchars($row['atta_quantity']); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>You have no bookings.</p>
<?php endif; ?>

</body>
</html>

<?php
mysqli_close($con);
?>
