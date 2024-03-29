<?php
session_start();
require_once './functions.php';
$con = getDBConnection();
$title = 'Добавить проект';
$uid = $_SESSION['user_id'];
$projects = getProjectsFromDB($con, $uid);
$user_info = getUserInfoFromDB($con, $uid);
$errors = [];
$tasks = getTasksFromDB($con, '', '', NULL, $uid);

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    if (!isset($_POST['name']) || $_POST['name'] == '') {
        $errors['name'] = 'Не указано имя';
    }
    elseif (strlen($_POST['name']) >= 30) {
        $errors['name'] = 'Название проекта не должно превышать 30 знаков';
    }
    if (!count($errors)) {
        createProjectInDB($con, $_POST['name'], $uid);
        header("Location: /index.php");
        exit;
    }
}

$content = includeTemplate('project-form.php', ['categories' => $projects, 'errors' => $errors]);
print includeTemplate('layout.php', ['categories' => $projects, 'content' => $content, 'title' => $title,
    'tasks' => $tasks, 'user_info' => $user_info]);

?>
