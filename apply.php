<?php
session_start();
include 'connect.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $etudeDeProjet = $_POST['etudeDeProjet'];
    $cvData = '';
    $cinData = '';
    $diplomeData = '';

    if (isset($_FILES['cv']) && $_FILES['cv']['error'] == UPLOAD_ERR_OK) {
        $cvData = file_get_contents($_FILES['cv']['tmp_name']);
    }

    if (isset($_FILES['cin']) && $_FILES['cin']['error'] == UPLOAD_ERR_OK) {
        $cinData = file_get_contents($_FILES['cin']['tmp_name']);
    }

    if (isset($_FILES['diplome']) && $_FILES['diplome']['error'] == UPLOAD_ERR_OK) {
        $diplomeData = file_get_contents($_FILES['diplome']['tmp_name']);
    }

    $trackingCode = rand(100000, 999999);

    if ($name && $email && $phone && $etudeDeProjet && $cvData && $cinData && $diplomeData) {
        $sql = "INSERT INTO applications (name, mail, phone, etudeDeProjet, cv, cin, diplome) VALUES (:name, :email, :phone, :etudeDeProjet, :cv, :cin, :diplome)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':etudeDeProjet', $etudeDeProjet);
        $stmt->bindParam(':cv', $cvData, PDO::PARAM_LOB);
        $stmt->bindParam(':cin', $cinData, PDO::PARAM_LOB);
        $stmt->bindParam(':diplome', $diplomeData, PDO::PARAM_LOB);

        if ($stmt->execute()) {
            $applicantId = $pdo->lastInsertId();
            $trackingCodeSql = "INSERT INTO trackingcodes (applicant_id, tracking_code) VALUES (:applicant_id, :tracking_code)";
            $trackingCodeStmt = $pdo->prepare($trackingCodeSql);
            $trackingCodeStmt->bindParam(':applicant_id', $applicantId);
            $trackingCodeStmt->bindParam(':tracking_code', $trackingCode);

            if ($trackingCodeStmt->execute()) {
                // Redirect to the confirmation page
                header("Location: confirmation.php?id=$applicantId");

                /*
                session_destroy();
                session_start();
                header('Location: apply.php'); */
            } else {
                echo "Error inserting tracking code into the database.";
            }
        } else {
            echo "Error inserting data into the database.";
        }
    } else {
        echo "Incomplete or invalid data submitted.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Apply to CyberParc Djerba</title>
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
            /* Add this line to include underlines */
        }

        .navbar a:hover,
        .navbar .active .dropdown .active {
            color: #ffc451;
            border-bottom: 2px solid #ffc451;
            /* Add this line to change the underline color on hover */
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
            margin-top: 70px;
            /* Adjust this value based on your navbar height */
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

    <main>
        <h1>Apply to CyberParc Djerba</h1>
        <form action="apply.php" method="POST" id="apply-form" enctype="multipart/form-data">
            <div>
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="phone">Phone</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            <div>
                <label for="etudeDeProjet">Etude de projet</label>
                <textarea id="etudeDeProjet" name="etudeDeProjet" cols="30" rows="10" required></textarea>
            </div>
            <div>
                <label for="cv">CV</label>
                <input type="file" id="cv" name="cv" required>
            </div>
            <div>
                <label for="cin">CIN</label>
                <input type="file" id="cin" name="cin" required>
            </div>
            <div>
                <label for="diplome">Diplome</label>
                <input type="file" id="diplome" name="diplome" required>
            </div>
            <div>
                <input type="submit" value="Submit">
            </div>
        </form>
    </main>

    <script>
        function submitForm() {
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const etudeDeProjet = document.getElementById('etudeDeProjet').value.trim();
            const cv = document.getElementById('cv').value.trim();

            if (name === '' || email === '' || phone === '' || etudeDeProjet === '' || cv === '') {
                alert('Please fill out all fields!');
                return;
            }

            alert(`Thank you ${name} for your etudeDeProjet!`);
        }
    </script>
</body>

</html>