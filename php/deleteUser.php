<?php
$servername = "localhost";  // або IP-адреса сервера бази даних
$dbname = 'authentication';
$username = 'root';
$password = 'secret';

// З'єднання з базою даних
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Перевірка з'єднання
if ($mysqli->connect_error) {
    die("Помилка з'єднання з базою даних: " . $mysqli->connect_error);
}

// Перевіряємо, чи прийшли дані методом POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $data = file_get_contents('php://input');

    // Розбиваємо JSON-дані на асоціативний масив
    $postData = json_decode($data, true);

    $name = $postData['name'];

    // Перевіряємо, чи існує користувач з таким іменем
    $userExists = $mysqli->query("SELECT COUNT(*) FROM users WHERE name='$name'")->fetch_row()[0] > 0;

    if ($userExists) {

        $resultDelete = $mysqli->query("DELETE FROM users WHERE name='$name'");

        if ($resultDelete) {
            echo json_encode(['success' => true, 'message' => 'Користувача видалено']);
        } else {
            echo json_encode(['success' => false, 'error' => $mysqli->error]);
        }
    } else {
        echo json_encode(['success' => true, 'message' => 'Такого користувача немає в системі']);
    }
} else {
    echo "error";
}

// Закриття з'єднання
$mysqli->close();
