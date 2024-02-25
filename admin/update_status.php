<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['user_id'];
    $newStatus = $_POST['status'];

    // Perform necessary validation and sanitation on $newStatus here

    // Update the status in the database
    $updateStatusStmt = $pdo->prepare("UPDATE job_applications SET status = :new_status WHERE user_id = :user_id");
    $updateStatusStmt->execute(['new_status' => $newStatus, 'user_id' => $userId]);

    // Redirect back to user details page
    header("Location: user-details.php?id=" . $userId);
    exit();
} else {
    // If the form is not submitted via POST, redirect to an error page or home page
    header("Location: error.php");
    exit();
}
?>
