INSERT INTO tasks
(name, project, user_id) VALUES ('Работа','Собеседование в IT','volage789@gmail.com');
(name, project, user_id) VALUES ('Учеба','Выполнить тестовое задание','ivanov@gmail.com');
(name, project, user_id) VALUES ('Домашние дела','Встреча с другом','ivanov@gmail.com');
(name, project, user_id) VALUES ('Домашние дела','Купить корм для кота','ivanov@gmail.com');
(name, project, user_id) VALUES ('Домашние дела','Заказать пиццу','ivanov@gmail.com');

-- получить список из всех проектов для одного пользователя
SELECT * FROM projects
WHERE user_id = 3;

-- получить список из всех задач для одного проекта
SELECT * FROM tasks
WHERE project_id = 5;

-- пометить задачу как выполненную;
UPDATE tasks SET status = 1 WHERE id = 7;

-- обновить название задачи по её идентификатору
UPDATE tasks SET name = 'Учеба' WHERE id = 7;