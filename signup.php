<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = ($_POST['password']); 
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $bio = $_POST['bio'];
    $selectedJobId = $_POST['jobs']; 

    $checkUsernameStmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $checkUsernameStmt->execute(['username' => $username]);

    if ($checkUsernameStmt->rowCount() > 0) {
        echo "<script>alert('Username already exists. Please choose a different username.');</script>";
        exit();
    }

    $insertUserStmt = $pdo->prepare("INSERT INTO users (username, password, name, email, phone, bio) VALUES (:username, :password, :name, :email, :phone, :bio)");

    try {
        $insertUserStmt->bindParam(':username', $username);
        $insertUserStmt->bindParam(':password', $password);
        $insertUserStmt->bindParam(':name', $name);
        $insertUserStmt->bindParam(':email', $email);
        $insertUserStmt->bindParam(':phone', $phone);
        $insertUserStmt->bindParam(':bio', $bio);
        $insertUserStmt->execute();

        $userId = $pdo->lastInsertId();

        $insertUserJobStmt = $pdo->prepare("INSERT INTO job_applications (user_id, job_id) VALUES (:user_id, :job_id)");
        $insertUserJobStmt->execute(['user_id' => $userId, 'job_id' => $selectedJobId]);

        echo "User registered successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

$sql = "SELECT * FROM jobs";
$stmt = $pdo->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sign Up</title>
    <link rel="icon" type="image/png" href="Logo_S2T.png">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
        }

        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            margin-bottom: 20px;
        }

        form {
            background-color: white;
            padding: 20px 40px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.8);
        }

        form h1 {
            margin: 0 0 20px 0;
            text-align: center;
            font-size: 24px;
            color: #333;
        }

        form label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #666;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"] {
            display: block;
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            margin-bottom: 20px;
        }

        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
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
    <form action="signup.php" method="post">
        <h1>Sign Up</h1>
        <label for="username">Username</label>
        <input type="text" name="username" placeholder="Enter your username" required>

        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Enter your password" required>

        <label for="email">Email</label>
        <input type="email" name="email" placeholder="Enter your email" required>

        <label for="name">Full Name</label>
        <input type="text" name="name" placeholder="Enter your full name" required>

        <label for="phone">Phone Number</label>
        <input type="text" name="phone" placeholder="Enter your phone number">

        <label for="bio">Bio</label>
        <textarea name="bio" placeholder="Enter your bio" cols="37" rows="8" required></textarea>

        <label for="jobs">Jobs List</label>
        <select name="jobs">
            <?php
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . $row['job_id'] . "'>" . $row['job_title'] . "</option>";
            }
            ?>
        </select>

        <input type="submit" value="Sign Up">
        <a href="login.php">Already have an account? Login here</a>
    </form>
    <br />
</body>

</html>