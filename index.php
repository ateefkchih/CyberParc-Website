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

        .welcome {
            width: 100%;
            height: 100vh;
            background-image: url("Resources/slide-one.jpg");
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 40px;
            /* Adjusted font size */
            color: #ffffff;
            font-family: Arial, sans-serif;
            text-align: center;
        }

        .img-wrapper {
            background-image: url("Resources/stock.jpg");
            background-size: cover;
            background-position: center;
            text-align: center;
            padding: 50px 20px;
            color: #ffffff;
        }

        .img-wrapper h1 {
            margin-bottom: 20px;
            color: #ffc451;
        }

        .container-wrapper {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin: 20px 0;
        }

        .contain {
            flex-basis: 45%;
            background-color: white;
            margin: 10px;
            padding: 20px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.8);
            text-align: justify;
        }

        .contain h2 {
            margin-bottom: 20px;
            color: #007bff;
            text-align: center;
        }

        .contact-info {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f4f4f4;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.8);
            text-align: center;
        }

        .contact-info p {
            margin-bottom: 15px;
            /* Adjust the bottom margin for more spacing between paragraphs */
        }

        .contact-info strong {
            color: #007bff;
        }


        .contain img {
            max-width: 50%;
            height: auto;
            margin: 0 auto;
            /* Add this line to center the image horizontally */
            display: block;
            /* Optional: Ensures the image is treated as a block element */
            margin-bottom: 10px;
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
    <div class="welcome">
        Welcome To CyberParc Djerba
    </div>
    <div class="img-wrapper">
        <h1>Our Mission</h1>
        <p>
            CyberParc Djerba is dedicated to promoting innovation, supporting digital entrepreneurship, and advancing
            technology to establish a dynamic hub for practical tech solutions.
        </p>
    </div>
    <div class="container-wrapper">
        <div class="contain">
            <h2>Functions</h2>
            <img src="Resources/event-1.jpg" alt="">
            <p>
                The goal of CYBER-PRC is to offer functional spaces, equipped with modern and specialized communication
                networks, to welcome promoters who wish to set up service projects based on new information and
                communication technologies. These services are oriented towards economic and administrative
                organizations located in the region, or in other parts of the country, or abroad, in the form of remote
                services.
            </p>
        </div>
        <div class="contain">
            <h2>Domain of activity</h2>
            <img src="Resources/equipement.jpg" alt="">
            <p>
                Call center<br>
                Software developments<br>
                Remote services related to ICT<br>
                Development and updates of websites<br>
                Hosting of business nurseries<br>
                Reservation of equipped spaces for remote work for people in a permanent mobility situation<br>
                Diversified services based on communication techniques
            </p>
        </div>
    </div>
    <div class="contact-info">
        <p><strong>Opening Hours:</strong> Monday - Saturday: 09:00 AM - 06:00 PM</p>
        <p><strong>Address:</strong> Bvld De l'environment BP N°474, Houmt Souk 4180, Tunisia</p>
        <p><strong>Phone:</strong> (+216) 75 659 297</p>
        <p><strong>Fax:</strong> (+216) 75 659 298</p>
        <p><strong>Email:</strong> <a href="mailto:k.ourimi@s2t.tn">k.ourimi@s2t.tn</a></p>
    </div>
</body>

</html>