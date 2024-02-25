<?php
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_email'])) {
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    if (!empty($id) && is_numeric($id)) {
        include 'connect.php';

        $mail = new PHPMailer(true);

        $sql = "SELECT mail, approval_status FROM applications WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $applicantEmail = $result['mail'];
            $approvalStatus = $result['approval_status'];
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
                $mail->Subject = 'Application Status';
                $mail->Body = 'Dear Applicant,

                We would like to inform you about the status of your application. Your application has been ' . $approvalStatus . '. 
                
                Thank you for your interest and participation.
                
                Best regards,
                Ateef';
                
                $mail->send();

                echo 'Email has been sent successfully.';
            } catch (Exception $e) {
                echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo 'Applicant not found in the database.';
        }
    } else {
        echo 'Invalid ID.';
    }
} else {
    echo 'Invalid request.';
}
?>
