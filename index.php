<?php
require_once('helpers.php');
// показывать или нет выполненные задачи
$show_complete_tasks = 1;

$connection_resource = mysqli_connect("localhost", "root", "root", "doingsdone");
mysqli_set_charset($connection_resource, "utf8");

if ($connection_resource == false) {
   print("Ошибка подключения: " . mysqli_connect_error());
}

$user_id = 1;  // если этот параметр поменять на двойку, то подгрузится вся инфа для второго пользователя из БД
$user_id = intval($user_id); // защита от иньекции на случай, если мы получаем $user_id извне

// получаю список проэктов
$sql_request_projects = "SELECT name, id FROM projects WHERE user_id = ".$user_id;
$result_request_projects = mysqli_query($connection_resource, $sql_request_projects);
$projects = mysqli_fetch_all($result_request_projects, MYSQLI_ASSOC);

// Получаю список задач

$sql_request_tasks = "SELECT task_name, dt_deadline, status, p.name, p.id FROM tasks t
JOIN projects p
ON t.projec_id = p.id
WHERE t.user_id = ".$user_id;
$result_request_tasks = mysqli_query($connection_resource, $sql_request_tasks);
$tasks = mysqli_fetch_all($result_request_tasks, MYSQLI_ASSOC);

// Получаю имя Юзера
$sql_request_user = "SELECT name FROM users WHERE id = ".$user_id;
$result_request_user = mysqli_query($connection_resource, $sql_request_user);
$user_name = mysqli_fetch_assoc($result_request_user);
$user_name = $user_name['name'];

function calculate_tasks ($project, $tasks) {
    $counter_task = 0;

    foreach ($tasks as $task) {
        if ($task['name'] == $project) {
            $counter_task++;
        }
    }

    return $counter_task;
};

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

if (isset($_GET['project_id'])) {
    $project_id = $_GET['project_id'];
    $sql_request_tasks_filtered_project = "SELECT task_name, dt_deadline, status, p.name, p.id FROM tasks t
    JOIN projects p
    ON t.projec_id = p.id
    WHERE p.id = ".$project_id."
    AND t.user_id = ".$user_id;
    $result_request_tasks_filtered_project = mysqli_query($connection_resource, $sql_request_tasks_filtered_project);
    $tasks_filtered_project = mysqli_fetch_all($result_request_tasks_filtered_project, MYSQLI_ASSOC);

    $page_content = include_template('main.php', ['projects' => $projects, 'tasks' => $tasks_filtered_project, 'show_complete_tasks' => $show_complete_tasks, 'tasks_for_calculate' => $tasks]);
} else {
    $page_content = include_template('main.php', ['projects' => $projects, 'tasks' => $tasks, 'show_complete_tasks' => $show_complete_tasks, 'tasks_for_calculate' => $tasks]);
}



$layout_content = include_template('layout.php', ['page_content' => $page_content, 'title' => 'Дела в порядке', 'user_name' => $user_name]);

print($layout_content);

?>

