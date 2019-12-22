<?php
require_once './functions.php';
$title = 'Вход на сайт';
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: /index.php");
    exit;
}
function auth() {
    $errors = [];
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return $errors;
    }
    if (!isset($_POST['email']) || $_POST['email'] == '') {
        $errors['email'] = 'Укажите email';
    }
    elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Укажите верный email';
    }
    if (!isset($_POST['password']) || $_POST['password'] == '') {
        $errors['password'] = 'Укажите пароль';
    }

    if (count($errors)) {
        return $errors;
    }
    $con = getDBConnection();
    $user = getUserFromDB($con, $_POST['email']);
    if ($user == NULL) {
        $errors['email'] = 'Пользователя с данным email не существует';
        return $errors;
    }
    $password = sha1($_POST['password']);
    if ($password != $user['password']) {
        $errors['password'] = 'Некорректный пароль';
        return $errors;
    }
    $_SESSION['user_id'] = $user['id'];
    header("Location: /index.php");
    exit;
}
$errors = auth();
$content = includeTemplate('auth-form.php', ['errors' => $errors]);
print includeTemplate('layout.php', ['content' => $content, 'title' => $title]);

?>
