<?php
include 'connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sqlUpdate = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['approve'])) {
            $sqlUpdate = "UPDATE applications SET approval_status = 'Approved' WHERE id = :id";
        } elseif (isset($_POST['reject'])) {
            $sqlUpdate = "UPDATE applications SET approval_status = 'Rejected' WHERE id = :id";
        }

        if (!empty($sqlUpdate)) {
            $stmtUpdate = $pdo->prepare($sqlUpdate);
            $stmtUpdate->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtUpdate->execute();
        }
    }

    $sql = "SELECT * FROM applications WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $applicant = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($applicant) {
        echo '
        
    <!DOCTYPE html>
                <html lang="en">
                <head>
                    <title>Applicant Details</title>
                    <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 0;
                        padding: 0;
                        background-color: #f4f4f4;
                    }
                    .approve-button, .reject-button, .mail-button{
                        padding: 10px 20px;
                        border: none;
                        border-radius: 5px;
                        font-size: 16px;
                        cursor: pointer;
                        margin: 10px;
                        transition: background-color 0.3s ease;
                        
                    }
                    
                    .approve-button {
                        background-color: #4CAF50; /* Green */
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
                        background-color: #f44336; /* Red */
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
                        box-shadow: 0px 0px 20px rgba(0,0,0,0.1);
                    }
                    
                    th, td {
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
                </head>
                <body>
                    <h1><a href ="application-admin-panel.php"> Admin Panel </a> </h1>
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Etude de Projet</th>
                            <th>CIN</th>
                            <th>CV</th>
                            <th>Diplome</th>
                        </tr>
                        <tr>
                            <td>' . $applicant['id'] . '</td>
                            <td>' . $applicant['name'] . '</td>
                            <td>' . $applicant['mail'] . '</td>
                            <td>' . $applicant['phone'] . '</td>
                            <td>' . $applicant['etudeDeProjet'] . '</td>
                            <td><img class="cv-image" src="show-cin.php?id=' . $applicant['id'] . '" alt="CV"></td>
                            <td><img class="cv-image" src="show-cv.php?id=' . $applicant['id'] . '" alt="CV"></td>
                            <td><img class="cv-image" src="show-diplome.php?id=' . $applicant['id'] . '" alt="CV"></td>
                        </tr>
                    </table>
                    <form method="post" action="">
                    <div class="button-container">
                        <input type="submit" value="Approve" class="approve-button" name="approve">
                        <input type="submit" value="Reject" class="reject-button" name="reject">
                    </div>
                </form>
                <form method="post" action="send_email.php" target="_blank">
                <div class="button-container">
                    <input type="submit" value="Send Email" class="mail-button" name="send_email">
                    <input type="hidden" name="id" value="' . $applicant["id"] . '">
                </div>
            </form>
            
                
                
                    
                </body>
                </html>';
    } else {
        echo 'Applicant not found.';
    }
} else {
    echo 'Invalid request.';
}
?>
