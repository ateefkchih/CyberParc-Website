<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if pending, approved, or rejected checkboxes are selected
    if (!empty($_POST['pending'])) {
        deleteSelectedApplications($_POST['pending']);
    }
    if (!empty($_POST['approved'])) {
        deleteSelectedApplications($_POST['approved']);
    }
    if (!empty($_POST['rejected'])) {
        deleteSelectedApplications($_POST['rejected']);
    }

    // Redirect back to admin panel after deletion
    header('Location: reservation-admin-panel.php');
    exit; // Ensure script stops execution after redirect
}

function deleteSelectedApplications($selectedIds)
{
    global $pdo;

    if (empty($selectedIds) || !is_array($selectedIds)) {
        // Handle invalid input
        return;
    }

    try {
        // Use placeholders for the selected IDs
        $placeholders = implode(',', array_fill(0, count($selectedIds), '?'));

        $sql = "DELETE FROM reservation_room WHERE id_reservation IN ($placeholders)";
        $stmt = $pdo->prepare($sql);

        // Bind each selected ID and execute the statement
        foreach ($selectedIds as $index => $id_reservation) {
            $stmt->bindValue($index + 1, $id_reservation, PDO::PARAM_INT);
        }

        $stmt->execute();
    } catch (PDOException $e) {
        // Handle database error
        echo "Error deleting records: " . $e->getMessage();
    }
}
?>