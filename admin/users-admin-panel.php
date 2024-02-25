<?php
include 'connect.php';

$sql = "SELECT * FROM users";
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<html>

<head>
    <title>
        Admin Panel
    </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
            font-family: Arial, sans-serif;
            padding: 20px;
            color: #ffffff;
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

        .listuser {
            color: black;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <nav class="col-md-2 d-none d-md-block sidebar">
        <div class="sidebar-sticky">
            <h2>
                Admin Panel's Dashboard
            </h2>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="users-admin-panel.php">
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
                    <a class="nav-link " href="application-admin-panel.php">
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
        <h2 class="listuser">Users List</h2>
        <?php if (!empty($users)): ?>
            <ul>
                <?php foreach ($users as $user): ?>
                    <li>
                        <a href="user-details.php?id=<?php echo $user['id_user']; ?>">
                            <?php echo $user['username']; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No users found.</p>
        <?php endif; ?>
    </main>
</body>

</html>