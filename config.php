<?php
// config.php
// Update these values for your environment
$BASE_URL = 'http://localhost/dabbangnew'; // change if needed

// DB
// $DB_HOST = 'localhost';
$DB_HOST = 'localhost:3309';
$DB_USER = 'root';
$DB_PASS = ''; // your DB password
$DB_NAME = 'dabbangnew'; // your DB name

// Connect
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}
$conn->set_charset('utf8mb4');

// Mail settings (change if you want SMTP; otherwise use PHP mail())
$MAIL_USE_SMTP = true; // set true to use SMTP, false to use PHP mail()
$MAIL_SMTP_HOST = 'email-smtp.us-east-1.amazonaws.com';
$MAIL_SMTP_PORT = 2587;
$MAIL_SMTP_USER = 'AKIA5OQ6466FZWEYNNVJ';
$MAIL_SMTP_PASS = 'BB8uQenn6fCEjW791mFxeUgQ39xwI/9PEBDPz7uasG58';
$MAIL_SMTP_SECURE = 'tls'; // 'ssl' or 'tls' or ''

// Sender
$MAIL_FROM_EMAIL = 'kushal.kamble@mitsde.com';
$MAIL_FROM_NAME  = 'WORKSMART';
