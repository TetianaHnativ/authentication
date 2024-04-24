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

    $password = $postData["password"];

    $username = $postData["username"];

    $passwordConfirm = $postData["passwordConfirm"];

    // Виконання SQL-запиту для отримання всіх даних з таблиці
    $sql_user_exist = "SELECT password, blocking, password_restrictions FROM users WHERE name = '$username'";
    $result = $mysqli->query($sql_user_exist);

    // Перевірка результату запиту
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $database_password = $row["password"];
        $blocking = $row["blocking"];
        $password_restrictions = $row["password_restrictions"];
        if ($blocking) {
            echo "Ваш обліковий запис заблоковано";
        } else {
            if (!$database_password) {
                echo "registration";
                if ($password === $passwordConfirm) {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $sql_insert_password = "UPDATE users SET password = '$hashed_password' WHERE name = '$username'";
                    if ($mysqli->query($sql_insert_password) === TRUE) {
                        if ($username === "ADMIN") {
                            echo " admin";
                        } else {
                            echo " user";
                        }
                    } else {
                        echo "Помилка при збереженні пароля: " . $mysqli->error;
                    }
                }
            } else if ($database_password && password_verify($password, $database_password) && $username === "ADMIN") {
                echo "admin";
            } else if ($database_password && password_verify($password, $database_password) && $username !== "ADMIN") {
                echo "user";
            } else if ($database_password) {
                echo "Неправильне ім'я або  пароль. Спробуйте ще раз";
            }
        }
    } else {
        echo "Неправильне ім'я або  пароль. Спробуйте ще раз";
    }
}

// Закриття з'єднання
$mysqli->close();
