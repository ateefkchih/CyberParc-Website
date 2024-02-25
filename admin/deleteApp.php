<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['pending'])) {
        deleteSelectedApplications($_POST['pending']);
    }
    if (!empty($_POST['approved'])) {
        deleteSelectedApplications($_POST['approved']);
    }
    if (!empty($_POST['rejected'])) {
        deleteSelectedApplications($_POST['rejected']);
    }

    header('Location: application-admin-panel.php');
}

function deleteSelectedApplications($selectedIds) {
    global $pdo;

    $placeholders = implode(',', array_fill(0, count($selectedIds), '?'));

    $sql = "DELETE FROM applications WHERE id IN ($placeholders)";
    $stmt = $pdo->prepare($sql);

    try {
        foreach ($selectedIds as $index => $id) {
            $stmt->bindValue($index + 1, $id, PDO::PARAM_INT);
        }
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error deleting records: " . $e->getMessage();
    }
}
?>
