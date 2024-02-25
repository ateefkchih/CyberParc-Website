<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $req = $pdo->prepare("SELECT * FROM users WHERE username=:username AND password=:password");
        $req->bindParam(':username', $username);
        $req->bindParam(':password', $password);
        $req->execute();

        $exist = $req->rowCount();
        if ($exist == 1) {
            session_start();
            $_SESSION['username'] = $username;
            header('Location: profile.php');
        } else {
            echo "Login ou mot de password incorrect";
        }
    } else {
        echo "Please provide both username and password.";
    }
}
?>


<html>

<head>
    <title>Index</title>
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
        input[type="password"] {
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
                            <li><a href="event-calendar.php">Event Calendar</a></li>
                        </ul>
                    </li>
                    <li><a class="nav-link scrollto " href="profile.php">Profile</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <form action="login.php" method="post">
        <h1>Connexion</h1>
        <label for="username">E-mail</label>
        <input type="text" name="username" placeholder="username" required>
        <label for="password">Mot De password</label>
        <input type="password" name="password" placeholder="password" required>
        <input type="submit" value="Valider" name="connexion">
        <a href="signup.php">S'inscrire</a>
    </form>
    <br />

</body>

</html>