<?php
require_once '../registration/config.php';

$name     = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
$where_to = mysqli_real_escape_string($conn, $_POST['where_to'] ?? '');
$guests   = (int)($_POST['guests'] ?? 0);
$email    = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
$arrival  = mysqli_real_escape_string($conn, $_POST['arrival'] ?? '');
$leaving  = mysqli_real_escape_string($conn, $_POST['leaving'] ?? '');

if (empty($name) || empty($email) || empty($arrival) || empty($leaving)) {
    echo "All required fields must be filled.";
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Please enter a valid email address.";
    exit;
}

$sql = "INSERT INTO bookings (name, email, where_to, guests, arrival_date, leaving_date)
        VALUES ('$name', '$email', '$where_to', $guests, '$arrival', '$leaving')";

if (mysqli_query($conn, $sql)) {
    echo "success";
} else {
    echo "Sorry, booking could not be saved. Please try again.";
}
?>
