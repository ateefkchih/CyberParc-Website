<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $nbrAttendees = $_POST['nbrAttendees'];
    $resDetails = $_POST['resDetails'];

    if ($name && $email && $phone && $date && $time && $nbrAttendees && $resDetails) {
        // Check if a reservation already exists for the specified date 
        $checkSql = "SELECT COUNT(*) FROM reservation_room WHERE date = :date ";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->bindParam(':date', $date);
        $checkStmt->execute();
        $reservationCount = $checkStmt->fetchColumn();

        if ($reservationCount > 0) {
            // Reservation already exists for the specified date and time
            echo "Reservation already exists for the selected date and time. Please choose a different date or time.";
        } else {
            // Insert the new reservation
            $insertSql = "INSERT INTO reservation_room (name, email, phone, date, time, nbrAttendees, resDetails) VALUES (:name, :email, :phone, :date, :time, :nbrAttendees, :resDetails)";
            $insertStmt = $pdo->prepare($insertSql);
            $insertStmt->bindParam(':name', $name);
            $insertStmt->bindParam(':email', $email);
            $insertStmt->bindParam(':phone', $phone);
            $insertStmt->bindParam(':date', $date);
            $insertStmt->bindParam(':time', $time);
            $insertStmt->bindParam(':nbrAttendees', $nbrAttendees);
            $insertStmt->bindParam(':resDetails', $resDetails);

            if ($insertStmt->execute()) {
                // Redirect to the confirmation page
                header("Location: confirmationReservation.php");
            } else {
                echo "Error inserting data into the database.";
            }
        }
    }
}
?>

<html>


<head>
    <title>Reservation</title>
    <link rel="icon" type="image/png" href="Logo_S2T.png">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
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

        form {
            max-width: 400px;
            margin: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.8);
        }

        form label {
            display: block;
            margin-bottom: 8px;
        }

        form input,
        form textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        form input[type="submit"] {
            background-color: #ffc451;
            color: #343a40;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #ffbb38;
        }
    </style>
</head>

<body>
    <h1>Reservation</h1>
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
                            <li><a href="event-calendar.php">Event Calendar</a></li>
                        </ul>
                    </li>
                    <li><a class="nav-link scrollto " href="profile.php">Profile</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <form action="reservation.php" method="post">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>

        <label for="phone">Phone</label>
        <input type="tel" name="phone" id="phone" required>

        <label for="date">Date</label>
        <input type="date" name="date" id="date" required>

        <label for="time">Time</label>
        <input type="time" name="time" id="time" required>

        <label for="nbrAttendees">Number of attendees</label>
        <input type="number" name="nbrAttendees" id="nbrAttendees" required>

        <label for="resDetails">Reservation Details</label>
        <textarea name="resDetails" id="resDetails" cols="30" rows="10"></textarea>

        <input type="submit" value="Submit">
    </form>
</body>

</html>