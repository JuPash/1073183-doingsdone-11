<?php
require_once './functions.php';
$title = 'Регистрация аккаунта';
$errors = [];

if ($_SERVER["REQUEST_METHOD"]=="POST") {
  if (!isset($_POST['email'])) {
    $errors['email'] = 'Укажите email';
  }
  elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Укажите верный email';
  }
  if (!isset($_POST['password']) || $_POST['password'] == '') {
    $errors['password'] = 'Укажите пароль';
  }
  elseif (strlen($_POST['password']) < 5) {
    $errors['password'] = 'Укажите пароль не менее 5 символов';
  }
  if (!isset($_POST['name']) || $_POST['name'] == '') {
    $errors['name'] = 'Укажите имя';
  }
}
$content = includeTemplate('register-form.php', ['errors' => $errors]);
print includeTemplate('layout.php', ['content' => $content, 'title' => $title]);
?>