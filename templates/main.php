        <div class="content">

            <?php print($main_navigation); ?>
            
            <main class="content__main">
                <h2 class="content__main-heading">Список задач</h2>

                <form class="search-form" action="index.php" method="get" autocomplete="off">
                    <input class="search-form__input" type="text" name="task_search" placeholder="Поиск по задачам"
                    <?php if (isset($_GET['task_search'])):?>
                        value="<?php print($_GET['task_search']); ?>"
                    <?php endif;?>>
                    <input class="search-form__submit" type="submit">
                </form>

                <div class="tasks-controls">
                    <nav class="tasks-switch">
                        <a href="?sorting_date=all" class="tasks-switch__item 
                        <?php if ($_GET['sorting_date'] == 'all'):?>tasks-switch__item--active<?php endif;?>">Все задачи</a>
                        <a href="?sorting_date=today" class="tasks-switch__item 
                        <?php if ($_GET['sorting_date'] == 'today'):?>tasks-switch__item--active<?php endif;?>">Повестка дня</a>
                        <a href="?sorting_date=tomorrow" class="tasks-switch__item 
                        <?php if ($_GET['sorting_date'] == 'tomorrow'):?>tasks-switch__item--active<?php endif;?>">Завтра</a>
                        <a href="?sorting_date=overdue" class="tasks-switch__item 
                        <?php if ($_GET['sorting_date'] == 'overdue'):?>tasks-switch__item--active<?php endif;?>">Просроченные</a>
                    </nav>

                    <label class="checkbox">
                        <!--добавить сюда атрибут "checked", если переменная $show_complete_tasks равна единице-->
                        <input class="checkbox__input visually-hidden show_completed" type="checkbox" <?php if ($show_complete_tasks): ?>checked<?php endif;?>>
                        <span class="checkbox__text">Показывать выполненные</span>
                    </label>
                </div>
                <?php if (count($tasks) != 0): ?>
                <table class="tasks">
                    <?php foreach ($tasks as $task): ?>
                        <?php if (!$show_complete_tasks && $task['status']): ?>
                            <?php continue; ?>
                        <?php else: ?>
                            <?php if (isset($_GET['project_id']) && $_GET['project_id'] != $task['projec_id']): ?>
                                <?php continue; ?>
                            <?php else: ?>
                            <?php if (isset($_GET['sorting_date']) && !sorting_by_date ($task['dt_deadline'], $_GET['sorting_date'])): ?>
                                <?php continue; ?>
                            <?php else: ?>
                            <tr class="tasks__item task 
                            <?php if ($task['status']): ?>
                                task--completed
                            <?php endif;?> 
                            <?php if ($task['dt_deadline'] and define_deadline_task($task['dt_deadline'])): ?>
                                task--important
                            <?php endif;?>">
                                <td class="task__select">
                                    <label class="checkbox task__checkbox">
                                        <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" 
                                        value="<?=($task['id']);?>" 
                                        <?php if ($task['status']):?>checked <?php endif;?>
                                        name="task_completed">
                                        <span class="checkbox__text"><?=htmlspecialchars($task['task_name']);?></span>
                                    </label>
                                </td>
                                <td class="task__date"><?=htmlspecialchars($task['dt_deadline']);?></td>
                                <td class="task__controls"><?=htmlspecialchars($task['name']);?></td>
                            </tr>
                            <?php endif;?>
                        <?php endif;?>
                        <?php endif;?>
                    <?php endforeach; ?>
                </table>
                <?php else: ?>
                <p>Ничего не найдено по Вашему запросу</p>
                <?php endif;?>
            </main>
        </div>