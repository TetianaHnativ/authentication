<?php
$host = 'localhost'; // або IP-адреса сервера бази даних
$dbname = 'authentication';
$username = 'root';
$password = 'secret';

// З'єднання з базою даних
$mysqli = new mysqli($host, $username, $password, $dbname);

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
    $blocking = $postData['blocking'];
    $passwordRestrictions = $postData['password_restrictions'];

    // Перевіряємо, чи існує користувач з таким іменем
    $sqlCheckUser = "SELECT COUNT(*) as count FROM users WHERE name=?";
    $stmtCheckUser = $mysqli->prepare($sqlCheckUser);
    $stmtCheckUser->bind_param("s", $name);
    $stmtCheckUser->execute();
    $resultCheckUser = $stmtCheckUser->get_result();
    $rowCheckUser = $resultCheckUser->fetch_assoc();
    $userExists = $rowCheckUser['count'] > 0;
    $stmtCheckUser->close();

    if ($userExists) {
        // Якщо користувач існує, виконуємо оновлення
        $sqlUpdate = "UPDATE users SET blocking=?, password_restrictions=? WHERE name=?";
        $stmtUpdate = $mysqli->prepare($sqlUpdate);
        $stmtUpdate->bind_param("sss", $blocking, $passwordRestrictions, $name);
        $resultUpdate = $stmtUpdate->execute();
        $stmtUpdate->close();

        if ($resultUpdate) {
            echo json_encode(['success' => true, 'message' => 'Користувача оновлено']);
        } else {
            echo json_encode(['success' => false, 'error' => $mysqli->error]);
        }
    } else {
        // Якщо користувача немає, виконуємо вставку нового запису
        $sqlInsert = "INSERT INTO users (name, blocking, password_restrictions) VALUES (?, ?, ?)";
        $stmtInsert = $mysqli->prepare($sqlInsert);
        $stmtInsert->bind_param("sss", $name, $blocking, $passwordRestrictions);
        $resultInsert = $stmtInsert->execute();
        $stmtInsert->close();

        if ($resultInsert) {
            echo json_encode(['success' => true, 'message' => 'Користувача додано']);
        } else {
            echo json_encode(['success' => false, 'error' => $mysqli->error]);
        }
    }
} else {
    // Виконання SQL-запиту для отримання всіх даних з таблиці
    $sql = "SELECT name, 
                   IF(blocking = 1, 'true', 'false') AS blocking, 
                   IF(password_restrictions = 1, 'true', 'false') AS password_restrictions 
              FROM users";
    $result = $mysqli->query($sql);

    // Перевірка результату запиту
    if ($result) {
        echo "<div class='table-container'>";
        // Виведення даних у вигляді HTML-таблиці
        echo "<table border='1' class='users-table'><tr><th>Ім'я</th><th>Блокування облікового запису</th><th>Обмеження на паролі</th></tr>";
        // Виведення кожного рядка даних
        while ($row = $result->fetch_assoc()) {
            echo "<tr onclick=\"editUser(this)\"><td>" . $row["name"] . "</td><td>" . $row["blocking"] . "</td><td>" . $row["password_restrictions"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "Помилка запиту: " . $mysqli->error;
    }
}

// Закриття з'єднання
$mysqli->close();
