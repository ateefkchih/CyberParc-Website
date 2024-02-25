<?php

include 'connect.php';

$result = null;

if (isset($_POST['tracking_code'])) {
    $trackingCode = $_POST['tracking_code'];

    $sql = "SELECT a.approval_status
            FROM applications a
            LEFT JOIN trackingcodes t ON a.id = t.applicant_id
            WHERE t.tracking_code = :tracking_code";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':tracking_code', $trackingCode, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>CyberParc Djerba</title>
    <link rel="icon" type="image/png" href="Logo_S2T.png">
    <style>
        body {
            margin: 0;
            padding-top: 50px;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            overflow: hidden;
            /* Hide scrollbars when the popup is open */
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

        main {
            padding-top: 60px;
        }

        #welcome {
            text-align: center;
            padding: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
        }

        form input[type="text"] {
            padding: 10px;
            width: 200px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        form input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #45a049;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            /* Semi-transparent black background */
            backdrop-filter: blur(10px);
            /* Apply blur effect */
            z-index: 1000;
        }

        .popup-container {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 1);
            z-index: 1001;
            max-width: 600px;
        }

        .popup-content {
            text-align: center;
            font-size: 20px;
        }

        .popup-close {
            cursor: pointer;
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 24px;
            /* Larger font size */
            color: #333;
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
                            <li><a href="trackingStatus.php">Event Calendar</a></li>
                        </ul>
                    </li>
                    <li><a class="nav-link scrollto " href="profile.php">Profile</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section id="welcome">
            <h1>Track Status</h1>
            <p>Enter your tracking code to check your application status.</p>
            <form action="trackingStatus.php" method="POST">
                <input type="text" name="tracking_code" placeholder="Tracking Code" required>
                <input type="submit" value="Track">
            </form>
        </section>
        <div class="overlay" id="overlay"></div>

        <?php
        if (isset($_POST['tracking_code'])) {
            ?>
            <div class="popup-container" id="popupContainer">
                <span class="popup-close" onclick="closePopup()">×</span>
                <div class="popup-content">
                    <?php
                    if ($result !== false && is_array($result)) {
                        echo "Approval Status: " . $result['approval_status'];
                    } else {
                        echo "No data found for the specified tracking code.";
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        ?>

        <script>
            function openPopup() {
                document.getElementById('popupContainer').style.display = 'block';
                document.getElementById('overlay').style.display = 'block';
            }

            function closePopup() {
                document.getElementById('popupContainer').style.display = 'none';
                document.getElementById('overlay').style.display = 'none';
            }

            // Open the popup when the page loads
            window.onload = openPopup;
        </script>
</body>

</html>