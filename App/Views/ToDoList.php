<?php include BASE_DIR . 'App/Views/partials/header.php'; ?>
<body class="page-index">

    <div id="wrapper">
        <div class="top-buttons">
            <a href="<?php echo BASE_URL . '?c=ToDoList&a=create'; ?>"><button class="btn btn-primary">Добавить новый</button></a>

            <?php if ($is_logged) : ?>
                <a href="<?php echo BASE_URL . '?c=login&a=logout'; ?>"><button class="btn btn-primary">Выйти</button></a>
            <?php else : ?>
                <a href="<?php echo BASE_URL . '?c=login'; ?>"><button class="btn btn-primary">Войти</button></a>
            <?php endif; ?>
        </div>

        <?php if (!empty($notifications)) : ?>
        <div class="notification mt-4">
            <?php for ($i = 0, $ci = count($notifications); $i < $ci; $i++) : ?>
                <div class="p-2 mb-2 bg-<?php echo $notifications[$i]['type']; ?> text-white rounded">
                    <?php echo $notifications[$i]['content']; ?>
                </div>
            <?php endfor; ?>
        </div>
        <?php endif; ?>

        <div class="sort-todolist mt-5">
            <div class="row">
                <div class="col">
                    <p class="pt-2 ps-3 mb-0">Сортировать по</p>
                </div>
                <div class="col">
                    <select class="form-select sort-by">
                        <option value="name"<?php echo ($sort_by == 'name' ? ' selected="selected"' : ''); ?>>имени</option>
                        <option value="email"<?php echo ($sort_by == 'email' ? ' selected="selected"' : ''); ?>>email</option>
                        <option value="status"<?php echo ($sort_by == 'status' ? ' selected="selected"' : ''); ?>>статусу</option>
                    </select>
                </div>
                <div class="col">
                    <select class="form-select sort-by-order">
                        <option value="ASC"<?php echo ($sort_by_order == 'ASC' ? ' selected="selected"' : ''); ?>>по возрастанию</option>
                        <option value="DESC"<?php echo ($sort_by_order == 'DESC' ? ' selected="selected"' : ''); ?>>по убыванию</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="todo-list mt-4">
            <ul class="list-group">
            <?php if (!empty($toDoList)) : ?>
                <?php for ($i = 0, $ci = count($toDoList); $i < $ci; $i++) : ?>
                <li class="list-group-item<?php echo ($is_logged ? ' pb-3' : ''); ?>">
                    <p class="mb-0"><?php echo $toDoList[$i]['name'] . ' - ' . $toDoList[$i]['email']; ?></p>
                    <p class="mt-3 mb-0"><?php echo nl2br($toDoList[$i]['task']); ?></p>
                    <p class="mt-3 mb-0"><?php echo ((int)$toDoList[$i]['status'] ? '<span class="text-success">Выполнено</span>' : '<span class="text-danger">Не выполнено</span>'); ?></p>
                    <?php echo ((int)$toDoList[$i]['edit_by_admin'] ? '<p class="mt-3 mb-0"><span class="text-success">Отредактировано администратором</span></p>' : ''); ?>
                    <?php if ($is_logged) : ?>
                    <p class="mt-3 mb-0">
                        <a href="<?php echo BASE_URL; ?>?c=ToDoList&a=edit&p[item_id]=<?php echo $toDoList[$i]['id']; ?>">
                            <button class="btn btn-primary">Редоктировать</button>
                        </a>
                    </p>
                    <?php endif; ?>
                </li>
                <?php endfor; ?>
            <?php else : ?>
                <li class="list-group-item">Items not found</li>
            <?php endif; ?>
            </ul>
        </div>
        <?php if ($itemsTotal > 3) : ?>
        <div class="list-pagination mt-4">
            <nav>
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link page-link-double-left<?php echo ($page < 2 ? ' disabled' : ''); ?>" href="<?php echo BASE_URL; ?>">
                            <i class="bi bi-chevron-double-left"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link page-link-left<?php echo ($page < 2 ? ' disabled' : ''); ?>" href="<?php echo ($page > 1 ? BASE_URL . '?page=' . ($page - 1) : '#'); ?>">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    </li>
                    <?php for ($i = 1; $i <= $pagesTotal; $i++) : ?>
                    <li class="page-item">
                        <a class="page-link<?php echo ($page == $i ? ' disabled' : ''); ?>" href="<?php echo ($page != $i  ? BASE_URL . '?page=' . $i : '#'); ?>"><?php echo $i; ?></a>
                    </li>
                    <?php endfor; ?>
                    <li class="page-item">
                        <a class="page-link page-link-double-right<?php echo ($pagesTotal <= $page ? ' disabled' : ''); ?>" href="<?php echo ($pagesTotal > $page  ? BASE_URL . '?page=' . ($page + 1) : '#'); ?>">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link page-link-right<?php echo ($pagesTotal <= $page ? ' disabled' : ''); ?>" href="<?php echo BASE_URL . '?page=' . $pagesTotal; ?>">
                            <i class="bi bi-chevron-double-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <?php endif; ?>
    </div>

<?php include BASE_DIR . 'App/Views/partials/footer.php'; ?>