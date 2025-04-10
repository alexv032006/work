<?php
$host = '127.0.0.1';
$user = 'root';
$pass = 'alex191';
$dbname = 'monit';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$login = $_POST['login'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT role FROM users WHERE login = ? AND password = ?");
$stmt->bind_param("ss", $login, $password);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($role);
    $stmt->fetch();

    echo "<h2>Добро пожаловать, $login!</h2>";

    // Таблица
    echo "<table border='1' cellpadding='8'>";
    echo "<tr><th>Имя</th>";

    if ($role === 'admin') {
        echo "<th>Email</th><th>Роль</th>";
    }

    echo "</tr>";

    
    $users = [
        ['name' => 'Александр', 'email' => 'alex06@example.com', 'role' => 'user'],
        ['name' => 'Анастасия', 'email' => 'anast07@example.com', 'role' => 'user'],
        ['name' => 'Админ', 'email' => 'admin@example.com', 'role' => 'admin']
    ];

    foreach ($users as $u) {
        echo "<tr><td>{$u['name']}</td>";
        if ($role === 'admin') {
            echo "<td>{$u['email']}</td><td>{$u['role']}</td>";
        }
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Неверный логин или пароль.";
}

$stmt->close();
$conn->close();
?>
