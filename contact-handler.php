<?php
include 'db_connect.php';

$name = $_POST['registeredName'];
$email = $_POST['registeredEmail'];
$message = $_POST['complaintText'];

if (empty($name) || empty($email) || empty($message)) {
    die("Please fill all fields.");
}

$stmt = $conn->prepare("INSERT INTO complaints (user_name, user_email, message) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $message);

if ($stmt->execute()) {
    echo "<script>alert('Thank you for your complaint! We will get back to you soon.'); window.location.href = '../contact.html';</script>";
} else {
    echo "<script>alert('Error submitting complaint. Please try again.'); window.location.href = '../contact.html';</script>";
}

$stmt->close();
$conn->close();
?>