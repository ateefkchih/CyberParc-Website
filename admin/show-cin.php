<?php
include 'connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT cin FROM applications WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        header('Content-Type: image/jpeg');
        header('Content-Disposition: inline; filename=" cin_' . $id . '.jpg"');

        echo $row['cin'];
        exit;
    }
}

header('HTTP/1.0 404 Not Found');
echo ' cin not found.';
exit;
?>