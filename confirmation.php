<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// confirmation.php

// Retrieve the ID from the URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

// Ensure the ID is valid
if (!empty($id) && is_numeric($id)) {
    include 'connect.php';

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    $sql = "SELECT mail, approval_status FROM applications WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $applicantEmail = $result['mail'];
        $approvalStatus = $result['approval_status'];
        $sqli = "SELECT tracking_code FROM trackingcodes WHERE applicant_id = :id";
        $stmti = $pdo->prepare($sqli);
        $stmti->bindParam(':id', $id, PDO::PARAM_INT);
        $stmti->execute();
        $resulti = $stmti->fetch(PDO::FETCH_ASSOC);
        $trackingCode = $resulti['tracking_code'];
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp-relay.brevo.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'ateefkchih@gmail.com';
            $mail->Password = 'vbLRWNjhTCI4z5HY';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('ateefkchih@gmail.com', 'Ateef');

            $mail->addAddress($applicantEmail, 'Applicant');

            $mail->isHTML(true);
            $mail->Subject = 'Tracking Code';
            $mail->Body = 'Dear Applicant,

            We trust this message finds you well. 
            
            Your application has been processed, and we are pleased to provide you with your tracking code: <strong>'.$trackingCode.'</strong>.
            
            This code will serve as a reference for your application throughout the evaluation process. Should you have any inquiries or require further assistance, please do not hesitate to reach out.
            
            Thank you for your continued interest in our organization.
            
            Best regards,
            Ateef';
            $mail->send();

        } catch (Exception $e) {
            echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo 'Applicant not found in the database.';
    }
} else {
    echo 'Invalid ID.';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Confirmation Page</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .confirmation-container {
            text-align: center;
            opacity: 0;
            animation: fadeIn 1.5s forwards;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.8);
        }

        h1 {
            color: #007bff;
        }

        p {
            font-size: 18px;
            color: #333;
        }

        strong {
            color: #e44d26;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <div class="confirmation-container">
        <h1>Confirmation Page</h1>
        <p>Thank you for your application. You will receive an email with your tracking code.</p>
    </div>
</body>

</html>