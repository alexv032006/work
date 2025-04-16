<?php
session_start();

if (isset($_SESSION['login'])) {
    header('Location: main.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli('127.0.0.1', 'root', 'alex191', 'monit');
    if ($conn->connect_error) die("Ошибка подключения: " . $conn->connect_error);

    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT role FROM users WHERE login=? AND password=?");
    $stmt->bind_param("ss", $login, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($role);
        $stmt->fetch();
        $_SESSION['login'] = $login;
        $_SESSION['role'] = $role;
        header("Location: main.php");
        exit;
    } else {
        $error = "Неверный логин или пароль.";
    }

    $stmt->close();
    $conn->close();
}


echo "<h2>Вход</h2>";
if (!empty($error)) echo "<p style='color:red;'>$error</p>";

echo '
<form method="post">
  <label>Логин: <input type="text" name="login" required></label><br><br>
  <label>Пароль: <input type="password" name="password" required></label><br><br>
  <input type="submit" value="Войти">
</form>';
?>
