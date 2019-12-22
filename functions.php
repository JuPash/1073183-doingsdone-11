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
    $format_to_check = 'Y-m-d';
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

/**
 * Получение пользователей из БД по email
 * @param string $connection Соединение с БД
 * @param array $email Email
 * @return int ID пользователя
 */
function getUserFromDB($connection, $email) {
    $sql = "SELECT id, password FROM users WHERE email = '$email'";
    $result = mysqli_query($connection, $sql);
    if ($result == false) {
        print "Ошибка запроса к БД: $sql";
        return NULL;
    }
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if (!count($users)) {
        return NULL;
    }
    return $users[0];
}

/**
 * Создание пользователей в БД
 * @param string $connection Соединение с БД
 * @param string $name Имя пользователя
 * @param string $email Email
 * @param string $password Пароль пользователя
 */
function createUserInDB($connection, $name, $email, $password) {
    $name = filterXSS($name);
    $password = sha1($password);
    $sql = "INSERT INTO users (email, name, password) VALUES ('$email', '$name', '$password');";
    $result = mysqli_query($connection, $sql);
    if ($result == false) {
        print "Ошибка добавления пользователя в базу данных: $sql";
    }
}

/**
 * Создание задач в БД
 * @param string $connection Соединение с БД
 * @param string $name Название задач
 * @param string $date Дата выполнения задачи
 * @param int $user ID пользователя
 * @param int $project ID проекта
 * @param string $file вложение
 */
function createTaskInDB($connection, $name, $date, $user, $project, $file) {
    $name = filterXSS($name);
    $sql = "INSERT INTO tasks (status, name, date_completed, user_id, project_id, file_path) VALUES (0, '$name', '$date', $user, $project, '$file');";
    $result = mysqli_query($connection, $sql);
    if ($result == false) {
        print 'Ошибка добавления в базу данных';
    }
}

/**
 * Создание проектов в БД
 * @param string $connection Соединение с БД
 * @param string $name Название задач
 * @param int $user ID пользователя
 */
function createProjectInDB($connection, $name, $user) {
    $name = filterXSS($name);
    $sql = "INSERT INTO projects (name, user_id) VALUES ('$name', $user);";
    $result = mysqli_query($connection, $sql);
    if ($result == false) {
        print 'Ошибка добавления в базу данных';
    }
}


/**
 * Получить проекты из базы данных
 * @param string $connection Соединение с БД
 * @param int $user ID пользователя
 */
function getProjectsFromDB($connection, $user) {
    $sql = "SELECT id, name FROM projects where user_id=$user";
    $result = mysqli_query($connection, $sql);
    $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $projects;
}

/**
 * Получить имя юзера из БД
 * @param string $connection Соединение с БД
 * @param int $user ID пользователя
 * @return array данные пользователя
 */
function getUserInfoFromDB($connection, $user) {
    $sql = "SELECT email, name FROM users where id=$user";
    $result = mysqli_query($connection, $sql);
    $user_info = mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
    return $user_info;
}

/**
 * Подключение к базе данных
 * @return array данные пользователя
 */
function getDBConnection() {
    $con = mysqli_connect("localhost", "root", "", "work_okay");
    if ($con == false) {
        print("Ошибка подключения: " . mysqli_connect_error());
        die;
    }
    mysqli_set_charset($con, "utf8");
    return $con;
}

/**
 * Отправляет почту
 * @param string $email Email
 * @param int $text Сообщение
 */
function sendEmail($email, $text) {
    $transport = (new Swift_SmtpTransport('phpdemo.ru', 25))
        ->setUsername('keks@phpdemo.ru')
        ->setPassword('htmlacademy');

    $mailer = new Swift_Mailer($transport);

    $message = (new Swift_Message('Уведомление о задаче'))
        ->setFrom(['keks@phpdemo.ru' => 'keks'])
        ->setTo([$email])
        ->setBody($text);

    $result = $mailer->send($message);
}
?>