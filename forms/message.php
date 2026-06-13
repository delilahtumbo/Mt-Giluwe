<?php
require_once '../registration/config.php';

$name    = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
$email   = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
$phone   = mysqli_real_escape_string($conn, $_POST['phone'] ?? '');
$country = mysqli_real_escape_string($conn, $_POST['country'] ?? '');
$message = mysqli_real_escape_string($conn, $_POST['message'] ?? '');

if (empty($email) || empty($message)) {
    echo "Email and message fields are required!";
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Enter a valid email address!";
    exit;
}

$sql = "INSERT INTO messages (name, email, phone, country, message)
        VALUES ('$name', '$email', '$phone', '$country', '$message')";

if (mysqli_query($conn, $sql)) {
    echo "Your message has been sent!";
} else {
    echo "Sorry, failed to send your message!";
}
?>
