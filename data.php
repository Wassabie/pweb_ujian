<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$servername = "localhost";
$username = "root";
$password = "";
$database = "crud_example";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$input = json_decode(file_get_contents("php://input"), true);

$method = $_SERVER['REQUEST_METHOD'];

if ($method === "POST") {
    $name = $input['name'];
    $email = $input['email'];
    $gender = $input['gender'];
    $stmt = $conn->prepare("INSERT INTO users (name, email, gender) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $gender);
    $stmt->execute();
} elseif ($method === "PUT") {
    $id = $input['id'];
    $name = $input['name'];
    $email = $input['email'];
    $gender = $input['gender'];
    $stmt = $conn->prepare("UPDATE users SET name=?, email=?, gender=? WHERE id=?");
    $stmt->bind_param("sssi", $name, $email, $gender, $id);
    $stmt->execute();
} elseif ($method === "DELETE") {
    $id = $input['id'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $conn->query("SET @count = 0;");
    $conn->query("UPDATE users SET id = (@count := @count + 1);");
    $conn->query("ALTER TABLE users AUTO_INCREMENT = 1;");
} else {
    $result = $conn->query("SELECT * FROM users");
    $data = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($data);
}

$conn->close();
?>
