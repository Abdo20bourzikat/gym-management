<?php

require '../../vendor/autoload.php';
// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['sendMail'])) {
    $filteredData = filterData($_POST);
    $objet = $filteredData['object'];
    $email = $filteredData['email'];
    $subject = $filteredData['subject'];

    // Validate data
    if (!empty($objet) && !empty($email) && !empty($subject)) {
        // Create a new PHPMailer instance
        $phpmailer = new PHPMailer();

        try {

            // Looking to send emails in production? Check out our Email API/SMTP product!
            $phpmailer->isSMTP();
            $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
            $phpmailer->SMTPAuth = true;
            $phpmailer->Port = 2525;
            $phpmailer->Username = 'c14fbd389b1a72';
            $phpmailer->Password = '143e2403dc7f3d';


            // // SMTP settings for Mailtrap
            // $mail->isSMTP();
            // $mail->Host = 'sandbox.smtp.mailtrap.io';
            // $mail->SMTPAuth   = true;
            // $mail->Username   = 'c14fbd389b1a72';
            // $mail->Password   = '143e2403dc7f3d';
            // // Enable TLS encryption
            // $mail->Port       = 587;
            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            // Recipients
            $phpmailer->setFrom('abdoubourzikat3@gmail.com', 'Gym Manager');
            // Recipient's email
            $phpmailer->addAddress($email);

            // Content
            $phpmailer->isHTML(true);
            $phpmailer->Subject = $objet;
            $phpmailer->Body    = nl2br($subject);
            $phpmailer->AltBody = strip_tags($subject);

            // Send the email
            $phpmailer->send();
            $_SESSION['success'] = "Email envoyé avec succès à $email";
        } catch (Exception $e) {
            $_SESSION['error'] = "Échec de l'envoi de l'email. Mailer Error: {$phpmailer->ErrorInfo}";
        }
    } else {
        $_SESSION['error'] = "Veuillez remplir tous les champs";
    }
}
?>

