<?php
require_once './functions.php';
$con = getDBConnection();
$title = 'Добавить задачу';
$projects = getProjectsFromDB($con);
$errors = [];
if ($_SERVER["REQUEST_METHOD"]=="POST"){
  if (!isset($_POST['name']) || $_POST['name'] == ''){
    $errors['name'] = 'Не указано имя';
  }
}

$content = includeTemplate('form.php', ['categories' => $projects, 'errors' => $errors]);
print includeTemplate('layout.php', ['categories' => $projects, 'content' => $content, 'title' => $title]);

?>