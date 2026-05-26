<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'dogadoption';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: adopt.html');
    exit;
}

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    header('Location: adopt.html?error=db');
    exit;
}

$fname = isset($_POST['fname']) ? $conn->real_escape_string($_POST['fname']) : '';
$lname = isset($_POST['lname']) ? $conn->real_escape_string($_POST['lname']) : '';
$email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';
$phone = isset($_POST['phone']) ? $conn->real_escape_string($_POST['phone']) : '';
$age = isset($_POST['age']) ? $conn->real_escape_string($_POST['age']) : '';
$home_type = isset($_POST['home_type']) ? $conn->real_escape_string($_POST['home_type']) : '';
$other_pets = isset($_POST['other_pets']) ? $conn->real_escape_string($_POST['other_pets']) : '';
$children = isset($_POST['children']) ? $conn->real_escape_string($_POST['children']) : '';
$hours_alone = isset($_POST['hours_alone']) ? $conn->real_escape_string($_POST['hours_alone']) : '';
$dog_interested = isset($_POST['dog_interested']) ? $conn->real_escape_string($_POST['dog_interested']) : '';
$message = isset($_POST['message']) ? $conn->real_escape_string($_POST['message']) : '';
$date_submitted = date('Y-m-d H:i:s');

$sql = "INSERT INTO applications (fname, lname, email, phone, age, home_type, other_pets, children, hours_alone, dog_interested, message, date_submitted)
        VALUES ('$fname', '$lname', '$email', '$phone', '$age', '$home_type', '$other_pets', '$children', '$hours_alone', '$dog_interested', '$message', '$date_submitted')";

if ($conn->query($sql) === TRUE) {
    $conn->close();
    header('Location: adopt.html?submitted=1');
    exit;
}

$conn->close();
header('Location: adopt.html?error=insert');
exit;
?>
