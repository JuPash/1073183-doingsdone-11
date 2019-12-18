<?php
session_start();
require_once './functions.php';
$con = getDBConnection();
$title = 'Добавить задачу';
$uid = $_SESSION['user_id'];
$projects = getProjectsFromDB($con, $uid);
$user_info = getUserInfoFromDB($con, $uid);
$errors = [];
$file_url = '';
if ($_SERVER["REQUEST_METHOD"]=="POST") {
  if (!isset($_POST['name']) || $_POST['name'] == '') {
    $errors['name'] = 'Не указано имя';
  }
  if (!isset($_POST['date']) || !is_date_valid($_POST['date'])) {
    $errors['date'] = 'Некорректная дата';
  }
  elseif (!isset($_POST['date']) || (strtotime($_POST['date']) < strtotime('today'))) {
    $errors['date'] = 'Дата должна быть больше или равна текущей';
  }
  $projectIdColumn = array_column($projects, 'id');
  if (!isset($_POST['project']) || (!in_array($_POST['project'], $projectIdColumn))) {
    $errors['project'] = 'Указанный проект не существует';
  }
  if (isset($_FILES['file']) && $_FILES['file']['name'] != '') {
    $file_name = $_FILES['file']['name'];
    $file_name = str_replace(';', '', $file_name);
    $file_name = str_replace("'", '', $file_name);
    $file_path = __DIR__ . '/uploads/';
    $file_url = '/uploads/' . $file_name;
    move_uploaded_file($_FILES['file']['tmp_name'], $file_path . $file_name);
  }
  if (count($errors) == 0) {
    createTaskInDB($con, $_POST['name'], $_POST['date'], $uid, $_POST['project'], $file_url);
    header("Location: /index.php");
    exit;
  }
}


$content = includeTemplate('form.php', ['categories' => $projects, 'errors' => $errors]);
print includeTemplate('layout.php', ['categories' => $projects, 'content' => $content, 'title' => $title,
  'user_info' => $user_info]);

?>