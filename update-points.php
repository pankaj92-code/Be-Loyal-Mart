<?php
include 'db_connect.php'; // Session start aur DB connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Agar login nahi hai, toh error bhejein
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit();
}

// JavaScript se bheja gaya data (JSON format mein) receive karein
$data = json_decode(file_get_contents('php://input'), true);
$points_to_add = $data['points'];

if (isset($points_to_add) && is_numeric($points_to_add)) {
    $user_id = $_SESSION['user_id'];
    
    // User ke current points mein naye points add karein
    $sql = "UPDATE users SET points = points + ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $points_to_add, $user_id);
    
    if ($stmt->execute()) {
        // Success
        echo json_encode(['success' => true, 'message' => 'Points updated!']);
    } else {
        // Failure
        echo json_encode(['success' => false, 'message' => 'Database error.']);
    }
    $stmt->close();
} else {
    // Invalid data
    echo json_encode(['success' => false, 'message' => 'Invalid points data.']);
}
$conn->close();
?>