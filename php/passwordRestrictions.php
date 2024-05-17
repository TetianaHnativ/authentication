<?php
//$host = 'localhost';  // або IP-адреса сервера бази даних
$servername = "localhost";
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

    $username = $postData["username"];

    // Виконання SQL-запиту для отримання інформації про обмеження паролів
    $sql_password_restrictions = "SELECT password_restrictions FROM users WHERE name = '$username'";
    $result = $mysqli->query($sql_password_restrictions);

    // Перевірка результату запиту
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $password_restrictions = $row["password_restrictions"];

        if ($password_restrictions) {
            echo "password_restrictions"; // Повертаємо сигнал про обмеження на пароль
        } else {
            echo "without_restrictions";
        }
    } else {
        $response["error"] = "No data found";
    }
}

// Закриття з'єднання
$mysqli->close();
