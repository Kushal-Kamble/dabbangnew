<?php
// inc/mailer.php
require_once __DIR__ . '/../config.php';

// include PHPMailer (your local download)
require_once __DIR__ . '/../PHPMailer/class.phpmailer.php';
require_once __DIR__ . '/../PHPMailer/class.smtp.php';

function sendMailHTML($toEmail, $toName, $subject, $htmlBody, $altBody = '') {
    global $MAIL_USE_SMTP, $MAIL_SMTP_HOST, $MAIL_SMTP_PORT, $MAIL_SMTP_USER, $MAIL_SMTP_PASS, $MAIL_SMTP_SECURE, $MAIL_FROM_EMAIL, $MAIL_FROM_NAME;

    $mail = new PHPMailer(true);

    try {
        if (!empty($MAIL_USE_SMTP)) {
            // Use SMTP (fill settings in config.php)
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = $MAIL_SMTP_HOST;
            $mail->Port = $MAIL_SMTP_PORT;
            $mail->Username = $MAIL_SMTP_USER;
            $mail->Password = $MAIL_SMTP_PASS;
            if (!empty($MAIL_SMTP_SECURE)) {
                $mail->SMTPSecure = $MAIL_SMTP_SECURE;
            }
        } else {
            // Use PHP mail() as backend
            $mail->isMail();
        }

        $mail->CharSet = 'UTF-8';
        $mail->SetFrom($MAIL_FROM_EMAIL, $MAIL_FROM_NAME);
        $mail->AddAddress($toEmail, $toName);
        $mail->AddReplyTo($MAIL_FROM_EMAIL, $MAIL_FROM_NAME);
        $mail->Subject = $subject;
        $mail->MsgHTML($htmlBody);
        $mail->AltBody = $altBody ?: strip_tags($htmlBody);

        return $mail->Send();
    } catch (Exception $e) {
        error_log("Mail error: " . $mail->ErrorInfo);
        return false;
    }
}
