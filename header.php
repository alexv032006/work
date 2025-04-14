<?php
// $role должен быть определён до подключения этого файла
if (!isset($role)) {
    $role = 'guest'; // на всякий случай
}

echo "<header style='background-color: #222; padding: 15px; text-align: center;'>";

$tabs = [
    'Главная' => '#',
    'Профиль' => '#',
    'Контакты' => '#',
    'Админ-панель' => '#',
    'Настройки' => '#'
];

$visibleTabs = ($role === 'admin') ? $tabs : array_slice($tabs, 0, 3);

foreach ($visibleTabs as $title => $link) {
    echo "<a href='$link' style='margin: 0 15px; color: white; text-decoration: none;'>$title</a>";
}

echo "</header><br>";
?>
