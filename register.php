<?php
require_once './functions.php';
$title = 'Регистрация аккаунта';
$errors = [];
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: /index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    if (!isset($_POST['email'])) {
        $errors['email'] = 'Укажите email';
    }
    elseif (strlen($_POST['email']) >= 45) {
        $errors['email'] = 'Email не должен превышать 45 символов';
    }
    elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Укажите верный email';
    }
    if (!isset($_POST['password']) || $_POST['password'] == '') {
        $errors['password'] = 'Укажите пароль';
    }
    elseif (strlen($_POST['password']) >= 60) {
        $errors['email'] = 'Пароль не должен превышать 60 символов';
    }
    elseif (strlen($_POST['password']) < 5) {
        $errors['password'] = 'Укажите пароль не менее 5 символов';
    }
    if (!isset($_POST['name']) || $_POST['name'] == '') {
        $errors['name'] = 'Укажите имя';
    }
    elseif (strlen($_POST['password']) >= 60) {
        $errors['email'] = 'Пароль не должен превышать 60 символов';
    }
    if (!count($errors)) {
        $con = getDBConnection();
        createUserInDB($con, $_POST['name'], $_POST['email'], $_POST['password']);
        $user = getUserFromDB($con, $_POST['email']);
        $_SESSION['user_id'] = $user['id'];
        header("Location: /index.php");
        exit;
    }
}

$content = includeTemplate('register-form.php', ['errors' => $errors]);
print includeTemplate('layout.php', ['content' => $content, 'title' => $title]);
?>
