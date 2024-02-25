<?php
include 'connect.php';

$reservation = null;

if (isset($_GET['id_reservation'])) {
    $id_reservation = $_GET['id_reservation'];
    $sqlUpdate = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['approve'])) {
            $sqlUpdate = "UPDATE reservation_room SET res_approval_status = 'approved' WHERE id_reservation = :id_reservation";
        } elseif (isset($_POST['reject'])) {
            $sqlUpdate = "UPDATE reservation_room SET res_approval_status = 'rejected' WHERE id_reservation = :id_reservation";
        }

        if (!empty($sqlUpdate)) {
            $stmtUpdate = $pdo->prepare($sqlUpdate);
            $stmtUpdate->bindParam(':id_reservation', $id_reservation, PDO::PARAM_INT);
            $stmtUpdate->execute();
        }
    }

    $sql = "SELECT * FROM reservation_room WHERE id_reservation = :id_reservation";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_reservation', $id_reservation, PDO::PARAM_INT);
    $stmt->execute();
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<html>

<head>
    <title>
        Reservation Details
    </title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .approve-button,
        .reject-button,
        .mail-button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin: 10px;
            transition: background-color 0.3s ease;

        }

        .approve-button {
            background-color: #4CAF50;
            /* Green */
            color: white;
        }

        .mail-button {
            background-color: #1114f0;
            color: white;
        }

        .mail-button:hover {
            background-color: #010380;
        }

        .reject-button {
            background-color: #f44336;
            /* Red */
            color: white;
        }

        .approve-button:hover {
            background-color: #45a049;
        }

        .reject-button:hover {
            background-color: #da190b;
        }

        h1 {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: #ffffff;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
            background-color: #ffffff;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .cv-image {
            max-width: 200px;
            height: auto;
        }

        a {
            color: #ffffff;
            text-decoration: none;
        }

        a:hover {
            color: #bbbbbb;
        }

        .button-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
    </style>
</head>

<body>
    <h1><a href="reservation-admin-panel.php">Admin Panel</a></h1>

    <?php
    if ($reservation) {
        echo '
        <table >
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date</th>
                <th>Time</th>
                <th>Attendees Number</th>
                <th>Details</th>
            </tr>
            <tr>
                <td>' . $reservation['id_reservation'] . '</td>
                <td>' . $reservation['name'] . '</td>
                <td>' . $reservation['email'] . '</td>
                <td>' . $reservation['phone'] . '</td>
                <td>' . $reservation['date'] . '</td>
                <td>' . $reservation['time'] . '</td>
                <td>' . $reservation['nbrAttendees'] . '</td>
                <td>' . $reservation['resDetails'] . '</td>
            </tr>
        </table>
        <form method="post" action="">
        <div class="button-container">
            <input type="submit" value="Approve" class="approve-button" name="approve">
            <input type="submit" value="Reject" class="reject-button" name="reject">
        </div>
    </form>';
    } else {
        echo 'Reservation not found.';
    }
    ?>
</body>

</html>