<?php
$host = '127.0.0.1';
$user = 'root';
$pass = 'alex191';
$dbname = 'monit';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$login = $_POST['login'] ?? null;
$password = $_POST['password'] ?? null;

echo "<!DOCTYPE html><html lang='ru'><head><meta charset='UTF-8'><title>Авторизация</title></head><body style='text-align: center;'>";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $login && $password) {
    $stmt = $conn->prepare("SELECT role FROM users WHERE login = ? AND password = ?");
    $stmt->bind_param("ss", $login, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($role);
        $stmt->fetch();

        include 'header.php'; // подключаем вкладки

        echo "<h2>Добро пожаловать, $login!</h2>";

        $users = [
            ['name' => 'Александр', 'email' => 'alex06@example.com', 'role' => 'user'],
            ['name' => 'Анастасия', 'email' => 'anast07@example.com', 'role' => 'user'],
            ['name' => 'Админ', 'email' => 'admin@example.com', 'role' => 'admin']
        ];

        echo "<table border='1' cellpadding='8' style='margin: 20px auto;'><tr><th>Имя</th>";
        if ($role === 'admin') {
            echo "<th>Email</th><th>Роль</th>";
        }
        echo "</tr>";

        foreach ($users as $u) {
            echo "<tr><td>{$u['name']}</td>";
            if ($role === 'admin') {
                echo "<td>{$u['email']}</td><td>{$u['role']}</td>";
            }
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<h2 style='color: red;'>Неверный логин или пароль.</h2>";
        echo "<a href='login.php'>Попробовать снова</a>";
    }

    $stmt->close();
} else {
    echo "<h2>Авторизация</h2>
    <form method='post'>
        <label>Логин: <input type='text' name='login' required></label><br><br>
        <label>Пароль: <input type='password' name='password' required></label><br><br>
        <input type='submit' value='Войти'>
    </form>";
}

$conn->close();
echo "</body></html>";
