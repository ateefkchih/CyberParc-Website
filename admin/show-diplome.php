<?php
include 'connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT diplome FROM applications WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        header('Content-Type: image/jpeg');
        header('Content-Disposition: inline; filename="DIPLOME_' . $id . '.jpg"');

        echo $row['diplome'];
        exit;
    }
}

header('HTTP/1.0 404 Not Found');
echo 'DIPLOME not found.';
exit;
?>