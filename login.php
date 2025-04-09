<?php
// Настройки базы данных
$host = '127.0.0.1';
$user = 'root';      // Стандартный пользователь
$pass = 'alex191';          // Стандартный пароль (обычно пустой)
$dbname = 'monit';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$login = $_POST['login'];
$password = $_POST['password'];

// Запрос на проверку логина и пароля
$stmt = $conn->prepare("SELECT role FROM users WHERE login = ? AND password = ?");
$stmt->bind_param("ss", $login, $password);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($role);
    $stmt->fetch();

    if ($role === 'admin') {
        echo "Добро пожаловать, администратор!";
    } else {
        echo "Добро пожаловать, пользователь!";
    }
} else {
    echo "Неверный логин или пароль.";
}

$stmt->close();
$conn->close();
?>
