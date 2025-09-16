<?php
// admin/newsletter_send.php
session_start();
if (empty($_SESSION['admin_logged_in'])) { header('Location: login.php'); exit; }
require_once "../config.php";
require_once "newsletter_send_helper.php";

if (empty($_GET['id'])) { die("Invalid id"); }
$id = (int)$_GET['id'];

send_newsletter_now($id, $conn, $BASE_URL);
header("Location: newsletters.php");
exit;
