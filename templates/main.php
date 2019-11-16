<section class="content__side">
                <h2 class="content__side-heading">Проекты</h2>

                <nav class="main-navigation">
                    <?php foreach ($categories as $key => $val): ?>
                    <ul class="main-navigation__list">
                        <li class="main-navigation__list-item">
                            <a class="main-navigation__list-item-link" href="#"><?= filterXSS($val['name']); ?></a>
                            <span class="main-navigation__list-item-count">
                            0
                            </span>
                        </li>
                    </ul>
                    <?php endforeach; ?>
                </nav>

                <a class="button button--transparent button--plus content__side-button" href="pages/form-project.html" target="project_add">Добавить проект</a>
            </section>


            <main class="content__main">
                <h2 class="content__main-heading">Список задач</h2>

                <form class="search-form" action="index.php" method="post" autocomplete="off">
                    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">
                    <input class="search-form__submit" type="submit" name="" value="Искать">
                </form>

                <div class="tasks-controls">
                    <nav class="tasks-switch">
                        <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
                        <a href="/" class="tasks-switch__item">Повестка дня</a>
                        <a href="/" class="tasks-switch__item">Завтра</a>
                        <a href="/" class="tasks-switch__item">Просроченные</a>
                    </nav>

                    <label class="checkbox">
                        <input class="checkbox__input visually-hidden show_completed" type="checkbox"
                        <?php
                            if ($showCompleteTasks == 1) { print("checked"); }
                        ?>
                        >
                        <span class="checkbox__text">Показывать выполненные</span>
                    </label>
                </div>

                <table class="tasks">
                    <?php foreach ($work as $item): ?>
                        <?php if ($showCompleteTasks == 0 && $item['status']) {
                            continue;
                        } ?>

                        <tr class="<?php
                            if (isUrgent($item['date_completed'])) {
                                print('task--important');
                            }
                        ?>
                        tasks__item task">
                        <td class="task__select <?php
                            if ($item['status']){
                                print('task--completed');
                            }
                            ?>
                            ">
                            <label class="checkbox task__checkbox">
                                <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="1">
                                <span class="checkbox__text"><?= filterXSS($item['name']); ?></span>
                            </label>
                        </td>
                        <td class="task__date"><?= filterXSS($item['date_completed']); ?></td>
                       </tr>
                    <?php endforeach; ?>
                </table>

            </main>