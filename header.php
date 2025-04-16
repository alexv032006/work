<?php
if (!isset($_SESSION)) session_start();

$role = $_SESSION['role'] ?? 'guest';

$tabs = [
    'Главная' => 'main.php',
    'Профиль' => '#',
    'Контакты' => '#',
    'Админ-панель' => '#',
    'Настройки' => '#'
];

$visible = $role === 'admin' ? $tabs : array_slice($tabs, 0, 3);

echo "<div style='background:#222;padding:10px;'>";
foreach ($visible as $title => $url) {
    echo "<a href='$url' style='color:white; margin-right:15px;'>$title</a>";
}
echo "<a href='logout.php' style='color:orange; float:right;'>Выйти</a>";
echo "</div><br>";
?>
