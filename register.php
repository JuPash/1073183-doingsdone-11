<?php
require_once './functions.php';
$title = 'Регистрация аккаунта';
$errors = [];
$content = includeTemplate('register-form.php', ['errors' => $errors]);
print includeTemplate('layout.php', ['content' => $content, 'title' => $title]);
?>