<?php
session_start(); // Start the session

// Database connection
$conn = mysqli_connect("localhost", "root", "", "ration");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get data from the form submission
$user_id = $_POST['user_id'];
$shop_id = $_POST['shop_id'];
$booking_date = $_POST['booking_date'];
$time_slot = $_POST['time_slot'];
$rice_quantity = intval($_POST['rice_quantity']);
$wheat_quantity = intval($_POST['wheat_quantity']);
$atta_quantity = intval($_POST['atta_quantity']);
$payment_method = $_POST['payment_method']; // Get payment method

// Check if there's already a booking for the same user in the same month
$month = date('Y-m', strtotime($booking_date));
$check_query = "SELECT COUNT(*) FROM bookings WHERE user_id = ? AND DATE_FORMAT(booking_date, '%Y-%m') = ?";
$stmt_check = mysqli_prepare($conn, $check_query);
mysqli_stmt_bind_param($stmt_check, 'is', $user_id, $month);
mysqli_stmt_execute($stmt_check);
mysqli_stmt_bind_result($stmt_check, $count);
mysqli_stmt_fetch($stmt_check);
mysqli_stmt_close($stmt_check);

if ($count > 0) {
    echo "<script>alert('You already have a booking for this month.'); window.location.href = 'userdash.php';</script>";
} else {
    // Prepare the SQL statement for inserting the booking
    $sql = "INSERT INTO bookings (user_id, shop_id, booking_date, time_slot, rice_quantity, wheat_quantity, atta_quantity, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Determine payment status based on the payment method
    $status = ($payment_method == 'online') ? 'paid' : 'pending'; // Adjust the status as needed

    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'iissiiis', $user_id, $shop_id, $booking_date, $time_slot, $rice_quantity, $wheat_quantity, $atta_quantity, $status);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Booking confirmed successfully!'); window.location.href = 'userdash.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
