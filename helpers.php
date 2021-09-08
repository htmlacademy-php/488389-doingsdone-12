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

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
}

/**
 * Возвращает корректную форму множественного числа
 * Ограничения: только для целых чисел
 *
 * Пример использования:
 * $remaining_minutes = 5;
 * echo "Я поставил таймер на {$remaining_minutes} " .
 *     get_noun_plural_form(
 *         $remaining_minutes,
 *         'минута',
 *         'минуты',
 *         'минут'
 *     );
 * Результат: "Я поставил таймер на 5 минут"
 *
 * @param int $number Число, по которому вычисляем форму множественного числа
 * @param string $one Форма единственного числа: яблоко, час, минута
 * @param string $two Форма множественного числа для 2, 3, 4: яблока, часа, минуты
 * @param string $many Форма множественного числа для остальных чисел
 *
 * @return string Рассчитанная форма множественнго числа
 */
function get_noun_plural_form (int $number, string $one, string $two, string $many): string
{
    $number = (int) $number;
    $mod10 = $number % 10;
    $mod100 = $number % 100;

    switch (true) {
        case ($mod100 >= 11 && $mod100 <= 20):
            return $many;

        case ($mod10 > 5):
            return $many;

        case ($mod10 === 1):
            return $one;

        case ($mod10 >= 2 && $mod10 <= 4):
            return $two;

        default:
            return $many;
    }
}

/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
function include_template($name, array $data = []) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) { // проверка читаемости файла
        return $result;
    }

    ob_start(); // начало буферизации
    extract($data); // превращение элементов массива в переменные
    require $name; // подключение шаблона с извлеченными данными

    $result = ob_get_clean(); // конец буферизации

    return $result; // возвращение  html кода с переданными данными
}

/**
* считает количество задачь по каждому из проектов, используется в main-navigation.php
*/

function calculate_tasks ($project, $tasks) {
    $counter_task = 0;

    foreach ($tasks as $task) {
        if ($task['name'] == $project) {
            $counter_task++;
        }
    }

    return $counter_task;
};

/**
* возвращает true, если до истечения deadline по задаче остается меньше 24 часов
*/

function define_deadline_task ($date) {
    $day_in_seconds = 86400;
    $analyzed_date = strtotime($date);
    $current_date = strtotime(date("Y-m-d G:i"));
    $flag = false;

    if ($day_in_seconds >= $analyzed_date - $current_date) {
        $flag = true;
    }

    return $flag;
};

function define_correctness_date ($date) {
    $analyzed_date = strtotime($date);
    $current_date = strtotime(date("Y-m-d"));
    $flag = false;

    if (0 <= $analyzed_date -  $current_date) {
        $flag = true;
    }

    return $flag;
};

function record_cookie ($cookie_name, $cookie_value) {
    
    $cookie_expire = strtotime('+1 MONTH', strtotime(date("Y-m-d G:i")));
    $cookie_path = "/";

    setcookie($cookie_name, $cookie_value, $cookie_expire, $cookie_path);
}

function sorting_by_date ($date, $filter) {
    $flag = false;
    $analyzed_date = strtotime($date);
    $current_date = strtotime(date("Y-m-d"));

    if ($filter == 'all') {
        $flag = true;
    } else if ($filter == 'today') {
        if ($analyzed_date == $current_date) {
            $flag = true;
        }
    } else if ($filter == 'tomorrow') {
        $current_date = strtotime('+1 DAY', strtotime(date("Y-m-d")));
        if ($analyzed_date == $current_date) {
            $flag = true;
        }        
    } else if ($filter == 'overdue') {
        if ($analyzed_date < $current_date) {
            $flag = true;
        }
    } else {
        $flag = false;
    }

    return $flag;
}