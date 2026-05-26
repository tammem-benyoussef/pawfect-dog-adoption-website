<?php
header('Content-Type: application/json');

$rawInput = file_get_contents('php://input');
$jsonData = json_decode($rawInput, true);

$name = '';
$email = '';
$dogName = '';

if (is_array($jsonData)) {
    $name = $jsonData['name'] ?? '';
    $email = $jsonData['email'] ?? '';
    $dogName = $jsonData['dog_name'] ?? '';
} else {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $dogName = $_POST['dog_name'] ?? '';
}

if ($name === '' || $email === '' || $dogName === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Missing required fields.'
    ]);
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'dogadoption');

if ($conn->connect_error) {
    echo json_encode([
        'success' => false,
        'message' => 'Database connection failed: ' . $conn->connect_error
    ]);
    exit;
}

$stmt = $conn->prepare('INSERT INTO enquiries (name, email, dog_name, date_submitted) VALUES (?, ?, ?, NOW())');
if (!$stmt) {
    echo json_encode([
        'success' => false,
        'message' => 'Prepare failed: ' . $conn->error
    ]);
    $conn->close();
    exit;
}

$stmt->bind_param('sss', $name, $email, $dogName);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Enquiry saved!'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Insert failed: ' . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
