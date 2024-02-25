<?php
include 'connect.php';

$sql = "SELECT * FROM applications";
$stmt = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            padding: 20px 0;
            background-color: #242939;
            border-right: 1px solid #dee2e6;
        }

        .sidebar-sticky {
            position: -webkit-sticky;
            position: sticky;
            top: 20px;
        }

        .nav-link {
            color: white;
            text-decoration: none;
        }

        .nav-link:hover {
            color: #007bff;
        }

        .nav-link.active {
            color: #007bff;
            font-weight: bold;
        }

        .nav-item {
            margin-bottom: 20px;
        }

        .content {
            margin-left: 200px;
            /* Adjust this value based on your sidebar width */
            padding: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin: 20px auto;
            background-color: #ffffff;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: left;
            height: 40px;
            /* Add this line to set the height of table cells */
        }

        /* Specific styling for links within table cells */
        table a {
            color: #333;
            text-decoration: none;
        }

        table a:hover {
            color: #007bff;
        }

        input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #f44336;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #da190b;
        }

        .div-center {
            text-align: center;
        }

        h2 {
            text-align: center;
            font-family: Arial, sans-serif;
            padding: 20px;
            color: #ffffff;
        }

        input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #007bff;
            border-radius: 4px;
            display: inline-block;
            position: relative;
            vertical-align: middle;
            /* Add this line to align the checkbox vertically */
        }

        input[type="checkbox"]:checked {
            background-color: #007bff;
            /* Background color for checked state */
            border-color: #007bff;
            /* Border color for checked state */
        }

        input[type="checkbox"]:checked::before {
            content: '\2713';
            /* Unicode character for checkmark */
            color: #ffffff;
            /* Color of the checkmark */
            font-size: 16px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        label.checkbox-label {
            display: inline-block;
            vertical-align: middle;
            margin-left: 5px;
            color: #333;
        }

        label {
            display: inline-block;
            vertical-align: middle;
            margin-left: 5px;
        }
        .listapp {
            color: black;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block sidebar">
                <div class="sidebar-sticky">
                    <h2>
                        Admin Panel's Dashboard
                    </h2>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="users-admin-panel.php">
                                Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="jobs.php">
                                Jobs
                            </a>
                        </li>
                    </ul>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="application-admin-panel.php">
                                Application Forms
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="reservation-admin-panel.php">
                                Reunion Room Reservation Forms
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-10 ms-sm-auto content">
            <h2 class="listapp">Applicant List</h2>
                <form action="deleteApp.php" method="POST" id="delete-form">
                    <table>
                        <tr>
                            <th>Pending</th>
                            <th>Approved</th>
                            <th>Rejected</th>
                        </tr>

                        <?php
                        $pendingApplications = [];
                        $approvedApplications = [];
                        $rejectedApplications = [];

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            switch ($row['approval_status']) {
                                case 'Pending':
                                    $pendingApplications[] = $row;
                                    break;
                                case 'Approved':
                                    $approvedApplications[] = $row;
                                    break;
                                case 'Rejected':
                                    $rejectedApplications[] = $row;
                                    break;
                                default:
                                    break;
                            }
                        }

                        $maxRowCount = max(count($pendingApplications), count($approvedApplications), count($rejectedApplications));

                        for ($i = 0; $i < $maxRowCount; $i++) {
                            echo '<tr>';

                            echo '<td>';
                            if (isset($pendingApplications[$i])) {
                                echo '<label>';
                                echo '<input type="checkbox" name="pending[]" value="' . $pendingApplications[$i]['id'] . '">';
                                echo '<a href="applicant-details.php?id=' . $pendingApplications[$i]['id'] . '">' . $pendingApplications[$i]['name'] . '</a>';
                                echo '</label>';
                            }
                            echo '</td>';

                            echo '<td>';
                            if (isset($approvedApplications[$i])) {
                                echo '<input type="checkbox" name="approved[]" value="' . $approvedApplications[$i]['id'] . '">';
                                echo '<a href="applicant-details.php?id=' . $approvedApplications[$i]['id'] . '">' . $approvedApplications[$i]['name'] . '</a>';
                            }
                            echo '</td>';

                            echo '<td>';
                            if (isset($rejectedApplications[$i])) {
                                echo '<input type="checkbox" name="rejected[]" value="' . $rejectedApplications[$i]['id'] . '">';
                                echo '<a href="applicant-details.php?id=' . $rejectedApplications[$i]['id'] . '">' . $rejectedApplications[$i]['name'] . '</a>';
                            }
                            echo '</td>';

                            echo '</tr>';
                        }
                        ?>
                    </table>
                    <div class="div-center">
                        <input type="submit" value="Delete Selected">
                    </div>
                </form>
</body>

</html>