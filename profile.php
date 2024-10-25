<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "ration");

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}


$user_id = $_SESSION['user_id'];

// Fetch user details from the database
$query = "SELECT name, phno, email, address, pincode, rcardno, card_color FROM users WHERE usid = $user_id";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            /* padding: 20px; */
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        p {
            font-size: 18px;
            color: #555;
        }
        .button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            text-align: center;
            background-color: #555;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 18px;
        }
        .button:hover {
            background-color: #0056b3;
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
    </style>
</head>
<body>
<nav class="navbar">
        <div class="navbar-title">E-RATION MANAGEMENT SYSTEM</div>
        <ul class="nav-menu">
            <li><a href="userdash.php">Dashboard</a></li>
            <li><a href="book_supplies.php">Book Supplies</a></li>
            <li><a href="slot_details.php">slot Details</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav> 
    <div class="container">
        <h1>User Profile</h1>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
        <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($user['phno']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
        <p><strong>Pincode:</strong> <?php echo htmlspecialchars($user['pincode']); ?></p>
        <p><strong>Ration Card Number:</strong> <?php echo htmlspecialchars($user['rcardno']); ?></p>
        <p><strong>Card Color:</strong> <?php echo htmlspecialchars($user['card_color']); ?></p>
        <a class="button" href="edit_profile.php">Edit Profile</a>
    </div>
</body>
</html>

<?php
mysqli_close($con);
?>
