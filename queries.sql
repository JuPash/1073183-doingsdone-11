--создаем пользователя
INSERT INTO users
(id, name, email, password) VALUES (1,'vasy','ivanov789@gmail.com', 'v3rtg3');

--создаем проекты
INSERT INTO projects (id, name, user_id) VALUES (1,'Работа',1);
INSERT INTO projects (id, name, user_id) VALUES (2,'Учеба', 1);
INSERT INTO projects (id, name, user_id) VALUES (3,'Входящие', 1);
INSERT INTO projects (id, name, user_id) VALUES (4,'Домашние дела', 1);
INSERT INTO projects (id, name, user_id) VALUES (5,'Авто', 1);

--создаем задачи
INSERT INTO tasks (id, status, name, user_id, project_id) VALUES (1, 0, 'Собеседование в IT', 1, 1);
INSERT INTO tasks (id, status, name, user_id, project_id) VALUES (2, 0,'Выполнить тестовое задание', 1, 2);
INSERT INTO tasks (id, status, name, user_id, project_id) VALUES (3, 0,'Встреча с другом', 1, 4);
INSERT INTO tasks (id, status, name, user_id, project_id) VALUES (4, 0,'Купить корм для кота', 1, 4);
INSERT INTO tasks (id, status, name, user_id, project_id) VALUES (5, 0,'Заказать пиццу', 1, 4);

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