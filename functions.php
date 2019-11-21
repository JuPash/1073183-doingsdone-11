<?php
/**
 * Проверяет переданную дату на соответствие формату 'ГГГГ-ММ-ДД'
 *
 * Примеры использования:
 * is_date_valid('2019-01-01'); // true
 * is_date_valid('2016-02-29'); // true
 * is_date_valid('2019-04-31'); // false
 * is_date_valid('10.10.2010'); // false
 * is_date_valid('10/10/2010'); // false
 *
 * @param string $date Дата в виде строки
 *
 * @return bool true при совпадении с форматом 'ГГГГ-ММ-ДД', иначе false
 */
function is_date_valid(string $date) : bool {
  $format_to_check = 'd.m.Y';
  $dateTimeObj = date_create_from_format($format_to_check, $date);

  return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
}
// Определяет осталось ли меньше 24 часов до конца задачи
function isUrgent($date) {
  if ($date == '') {
    return false;
  }
  $timeStamp = strtotime($date);
  $difference = $timeStamp - time();
  if ($difference < 86400) {
    return true;
  }
  else {
    return false;
  }
}

/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
function includeTemplate($name, array $data = []) {
  $name = 'templates/' . $name;
  $result = 'not found';

  if (!is_readable($name)) {
      return $result;
  }

  ob_start();
  extract($data);
  require $name;

  $result = ob_get_clean();

  return $result;
}

/**
 * Убирает специальные символы от данных, введенных пользователем
 * @param string $data Пользовательский ввод
 * @return string Обработанные данные
 */
function filterXSS($data) {
  $data = strip_tags($data);
  $data = htmlentities($data, ENT_QUOTES, "UTF-8");
  $data = htmlspecialchars($data, ENT_QUOTES);
  return $data;
}

/**
 * Считает количество задач для категорий
 * @param string $category Название категории
 * @param array $tasks Массив задач
 * @return int Количество задач
 */
function categoryTaskCount($category, $tasks)
{
    $count = 0;
    foreach ($tasks as $task) {
        if ($task ['category'] == $category) {
            $count++;
        }
    }
    return $count;
}

//получить проекты из базы данных
function getProjectsFromDB($connection) {
  $sql = "SELECT id, name FROM projects";
  $result = mysqli_query($connection, $sql);
  $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
  return $projects;
}

//подключение к базе данных
function getDBConnection() {
  $con = mysqli_connect("localhost", "root", "", "work_okay");
  if ($con == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
    die;
  }
  mysqli_set_charset($con, "utf8");
  return $con;
}

?>