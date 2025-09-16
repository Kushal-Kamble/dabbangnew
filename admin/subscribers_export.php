<?php
// admin/subscribers_export.php
session_start();
if (empty($_SESSION['admin_logged_in'])) { header('Location: login.php'); exit; }
require_once "../config.php";

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=subscribers.csv');

$output = fopen('php://output', 'w');
fputcsv($output, ['ID','Name','Email','Status','Created At']);

$res = $conn->query("SELECT id,name,email,status,created_at FROM subscribers ORDER BY id");
while($r=$res->fetch_assoc()){
    fputcsv($output, [$r['id'],$r['name'],$r['email'],$r['status'],$r['created_at']]);
}
fclose($output);
exit;
