            <main class="content__main">
                <h2 class="content__main-heading">Список задач</h2>

                <form class="search-form" action="index.php" method="get" autocomplete="off">
                    <input class="search-form__input" type="text" name="search" value="" placeholder="Поиск по задачам">
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
                    <?php
                    if (count($work) == 0) {
                        print ('<div class="tasks-notasks">Задач не найдено</div>');
                    }
                    foreach ($work as $item): ?>
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
                                <span class="checkbox__text"><?= filterXSS($item['name']); ?>
                                <?php
                                if ($item['file_path'] != null) {
                                ?>
                                <a class="download-link" href="<?= $item['file_path']; ?>"></a>
                                <?php } ?>
                                </span>

                            </label>
                        </td>
                        <td class="task__date"><?= filterXSS($item['date_completed']); ?></td>
                       </tr>
                    <?php endforeach; ?>
                </table>

            </main>