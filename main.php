<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

include 'header.php';

$login = $_SESSION['login'];
$role = $_SESSION['role'];

echo "<h2>Добро пожаловать, $login!</h2>";

$users = [
    ['name' => 'Александр', 'email' => 'alex@example.com', 'role' => 'user'],
    ['name' => 'Наталья', 'email' => 'nata@example.com', 'role' => 'user'],
    ['name' => 'Админ', 'email' => 'admin@example.com', 'role' => 'admin']
];

echo "<table border='1' cellpadding='8'><tr><th>Имя</th>";
if ($role === 'admin') echo "<th>Email</th><th>Роль</th>";
echo "</tr>";

foreach ($users as $u) {
    echo "<tr><td>{$u['name']}</td>";
    if ($role === 'admin') {
        echo "<td>{$u['email']}</td><td>{$u['role']}</td>";
    }
    echo "</tr>";
}
echo "</table>";
?>
