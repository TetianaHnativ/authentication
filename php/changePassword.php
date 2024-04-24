<?php
//$host = 'localhost';  // або IP-адреса сервера бази даних
$servername = "localhost";
$dbname = 'authentication';
$username = 'root';
$password = '';

// З'єднання з базою даних
$mysqli = new mysqli($servername, $username, $password, $dbname);
//$mysqli = new mysqli($host, $username, $password, $dbname);

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

    $oldPassword = $postData["oldPassword"];

    $newPassword = $postData["newPassword"];

    $passwordConfirm = $postData["passwordConfirm"];

    $sql_user_exist = "SELECT password FROM users WHERE name = '$username'";
    $result = $mysqli->query($sql_user_exist);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $database_password = $row["password"];

        if (password_verify($oldPassword, $database_password)) {
            if ($newPassword === $passwordConfirm) {
                $hashed_new_password = password_hash($newPassword, PASSWORD_DEFAULT);
                $sql_update_password = "UPDATE users SET password = '$hashed_new_password' WHERE name = '$username'";
                if ($mysqli->query($sql_update_password) === TRUE) {
                    echo "success";
                } else {
                    echo "Помилка при оновленні пароля: " . $mysqli->error;
                }
            } else {
                echo "Нові паролі не співпадають";
            }
        } else {
            echo "Неправильний поточний пароль";
        }
    } else {
        echo "Користувача не знайдено";
    }
}
