<?php
include 'connect.php';

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];
$stmt = $pdo->prepare("SELECT u.*, j.job_title, ja.status
                      FROM users u
                      LEFT JOIN job_applications ja ON u.id_user = ja.user_id
                      LEFT JOIN jobs j ON ja.job_id = j.job_id
                      WHERE u.username = :username");

$stmt->execute(['username' => $username]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Profile</title>
    <link rel="icon" type="image/png" href="Logo_S2T.png">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .profile-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px 0px rgba(0, 0, 0, 0.7);
            width: 80%;
            max-width: 500px;
        }

        .profile-container h1 {
            margin-bottom: 20px;
            color: #333;
        }

        .profile-container p {
            font-size: 16px;
            color: #666;
            margin-bottom: 20px;
        }

        .profile-container label {
            font-size: 14px;
            color: #333;
            margin-bottom: 5px;
        }

        .profile-container a {
            display: inline-block;
            padding: 10px 20px;
            color: white;
            background-color: #007bff;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 20px;
        }

        .profile-container a:hover {
            background-color: #0056b3;
        }

        header {
            background-color: #333;
            color: #ffffff;
            padding: 10px 0;
            width: 100%;
            position: fixed;
            top: 0;
            z-index: 1000;
        }

        .navbar {
            display: flex;
            justify-content: center;
        }

        .navbar ul {
            margin: 0;
            padding: 0;
            display: flex;
            list-style: none;
            align-items: center;
        }

        .navbar li {
            margin-right: 20px;
        }

        .navbar a {
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
            border-bottom: 2px solid transparent;
        }

        .navbar a:hover,
        .navbar .active {
            color: #ffc451;
            border-bottom: 2px solid #ffc451;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown ul {
            display: none;
            position: absolute;
            background-color: #404040;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            padding: 12px 16px;
            z-index: 1;
        }

        .dropdown:hover ul {
            display: block;
        }

        .dropdown ul li {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown li {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
    </style>
</head>

<body>
    <header>
        <div class="container d-flex align-items-center justify-content-lg-between">
            <nav id="navbar" class="navbar order-last order-lg-0">
                <ul>
                    <li><a class="nav-link scrollto " href="index.php">Home</a></li>
                    <li class="dropdown "><a href="#"><span>Join Us</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="apply.php">Apply</a></li>
                            <li><a href="trackingStatus.php">Track Your Application</a></li>
                        </ul>
                    </li>
                    <li class="dropdown "><a href="#"><span>Events</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a class="nav-link scrollto " href="reservation.php">Reunion Room</a></li>
                            <li><a href="Tracking Status">Event Calendar</a></li>
                        </ul>
                    </li>
                    <li><a class="nav-link scrollto " href="profile.php">Profile</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="profile-container">
        <h1>Profile</h1>
        <?php if ($userData !== false) : ?>
            <p>Welcome, <?php echo $userData['username']; ?>!</p>
            <p>
                <label for="email">Email:</label>
                <?php echo $userData['email']; ?>
            </p>
            <p>
                <label for="full_name">Full Name:</label>
                <?php echo $userData['name']; ?>
            </p>
            <p>
                <label for="phone">Phone:</label>
                <?php echo $userData['phone']; ?>
            </p>
            <p>
                <label for="bio">Bio:</label>
                <?php echo $userData['bio']; ?>
            </p>
            <p>
                <label for="job_status">Job Status:</label>
                <?php echo isset($userData['status']) ? $userData['status'] : 'N/A'; ?>
            </p>

            <a href="logout.php">Logout</a>
        <?php else : ?>
            <p>No user data found.</p>
        <?php endif; ?>
    </div>
</body>

</html>