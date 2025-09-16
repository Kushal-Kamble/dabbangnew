<?php
header('Content-Type: application/json'); // 👈 ye add karna important hai

// Uploads folder ka path
$uploadDir = __DIR__ . '/uploads/';
$uploadUrl = 'http://localhost/mitsdenewsletter/admin/uploads/';

// Agar folder exist nahi karta to create karo
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if (!empty($_FILES['upload'])) {
    $fileName = time() . '_' . basename($_FILES['upload']['name']); // 👈 unique filename
    $targetFile = $uploadDir . $fileName;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Sirf images allow karo
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array($fileType, $allowedTypes)) {
        echo json_encode([
            "error" => [
                "message" => "Only image files are allowed."
            ]
        ]);
        exit;
    }

    // File move
    if (move_uploaded_file($_FILES['upload']['tmp_name'], $targetFile)) {
        echo json_encode([
            "url" => $uploadUrl . $fileName
        ]);
    } else {
        echo json_encode([
            "error" => [
                "message" => "Failed to upload file."
            ]
        ]);
    }
} else {
    echo json_encode([
        "error" => [
            "message" => "No file uploaded."
        ]
    ]);
}
