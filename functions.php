<?php

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

function filterXSS($data) {
  $data = strip_tags($data);
  $data = htmlentities($data, ENT_QUOTES, "UTF-8");
  $data = htmlspecialchars($data, ENT_QUOTES);
  return $data;
}

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

?>