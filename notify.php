<?php

require_once './functions.php';
$con = getDBConnection();
$sql = "SELECT user_id, name FROM tasks WHERE TIME(date_completed) < NOW() + INTERVAL 1 HOUR";

$result = mysqli_query($con, $sql);
if ($result == false) {
  print("Ошибка подключения: " . mysqli_error($con));
  die;
}
  //преобразовываем результат в массив
$tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
foreach ($tasks as $task) {
  $user_info = getUserInfoFromDB($con, $task['user_id']);
  sendEmail($user_info['email'], 'Задача ' . $task['name'] . ' скоро истекает.');
}

?>