USE doingsdone;

-- добавляем двух пользователей
INSERT INTO users SET name = 'Константин', password = 'kstn123', email = 'kstn@kstn.ru';
INSERT INTO users SET name = 'Дмитрий', password = 'dmlvr2121', email = 'lvr@dmlvr.ru';

-- добавляем существующие проекты
INSERT INTO projects SET name = 'Входящие', user_id = 1;
INSERT INTO projects SET name = 'Учеба', user_id = 1;
INSERT INTO projects SET name = 'Работа', user_id = 1;
INSERT INTO projects SET name = 'Домашние дела', user_id = 1;
INSERT INTO projects SET name = 'Авто', user_id = 1;

-- добавляю пару проектов для нового пользователя
INSERT INTO projects SET name = 'Хобби', user_id = 2;
INSERT INTO projects SET name = 'Другое', user_id = 2;

-- добавляем существующие задачи
INSERT INTO tasks SET task_name = 'Собеседование в IT компании', projec_id = 3, user_id = 1, status = 0, dt_deadline = '2021-06-02';
INSERT INTO tasks SET task_name = 'Выполнить тестовое задание', projec_id = 2, user_id = 1, status = 0, dt_deadline = '2021-06-03';
INSERT INTO tasks SET task_name = 'Встреча с другом', projec_id = 1, user_id = 1, status = 0, dt_deadline = '2021-02-06';
INSERT INTO tasks SET task_name = 'Купить корм для кота', projec_id = 4, user_id = 1, status = 0;
INSERT INTO tasks SET task_name = 'Заказать пиццу', projec_id = 4, user_id = 1, status = 0;
INSERT INTO tasks SET task_name = 'Сделать задание первого раздела', projec_id = 2, user_id = 1, status = 1, dt_deadline = '2019-12-21';

-- добавляем пару задач для нового пользователя
INSERT INTO tasks SET task_name = 'Поход в КВИЗ', projec_id = 6, user_id = 2, status = 0, dt_deadline = '2021-06-15';
INSERT INTO tasks SET task_name = 'Покупка Xbox', projec_id = 7, user_id = 2, status = 0, dt_deadline = '2021-08-22';

-- получить список из всех проектов для одного пользователя
SELECT name FROM projects WHERE user_id = 1;

-- получить список из всех задач для одного проекта
SELECT task_name FROM tasks WHERE projec_id = 4;

-- пометить задачу как выполненную
UPDATE tasks SET status = 1 WHERE task_name = 'Собеседование в IT компании';

-- обновить название задачи по её идентификатору
UPDATE tasks SET task_name = 'Купить сухой корм для кота' WHERE id = 4;