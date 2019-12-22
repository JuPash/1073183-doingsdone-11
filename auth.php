<?php
require_once './functions.php';
$title = 'Вход на сайт';
$errors = [];

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    if (!isset($_POST['email']) || $_POST['email'] == '') {
        $errors['email'] = 'Укажите email';
    }
    elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Укажите верный email';
    }
    if (!isset($_POST['password']) || $_POST['password'] == '') {
        $errors['password'] = 'Укажите пароль';
    }

    if (count($errors) == 0) {
        $con = getDBConnection();
        $user = getUserFromDB($con, filterXSS($_POST['email']));
        if ($user == NULL) {
            $errors['email'] = 'Пользователя с данным email не существует';
        }
        else {
            $password = sha1($_POST['password']);
            if ($password != $user['password']) {
                $errors['password'] = 'Некорректный пароль';
            }
            else {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                header("Location: /index.php");
                exit;
            }
        }
    }
}

$content = includeTemplate('auth-form.php', ['errors' => $errors]);
print includeTemplate('layout.php', ['content' => $content, 'title' => $title]);

?>
