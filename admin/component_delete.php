<?php
require_once "../config.php";

$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("DELETE FROM component_master WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: components.php?msg=Component Deleted Successfully");
exit;
