<?php include BASE_DIR . 'App/Views/partials/header.php'; ?>

<body class="page-add-new">
    <div id="wrapper">
        <form action="<?php echo BASE_URL; ?>?c=ToDoList&a=save" method="POST">
            <?php if (!empty($errors)) : ?>
            <div class="errors">
                <div class="p-2 mb-3 bg-danger text-white rounded">
                    <?php for ($i = 0, $ci = count($errors); $i < $ci; $i++) : ?>
                    <p class="mb-0"><?php echo $i + 1; ?>. <?php echo $errors[$i]; ?></p>
                    <?php endfor; ?>
                </div>
            </div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="name" class="form-label">Имя</label>
                <input type="text" class="form-control" id="name" name="name"<?php echo (!empty($name) ? ' value="'.$name.'"' : ''); ?>>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Адрес электронной почты</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="name@example.com"<?php echo (!empty($email) ? ' value="'.$email.'"' : ''); ?>>
            </div>
            <div class="mb-3">
                <label for="task" class="form-label">Задача</label>
                <textarea class="form-control" id="task" name="task" rows="5"><?php echo (!empty($task) ? $task : ''); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="task" class="form-label">Статус</label>
                <input type="checkbox" class="form-check-input ms-3" value="1" name="status" id="status"<?php echo (!empty($status) && (int)$status ? ' checked="checked"' : ''); ?>>
            </div>


            <div class="mb-3">
                <input type="hidden" name="id" value="<?php echo (!empty($id) ? $id : 0); ?>">
                <input type="submit" class="btn btn-primary" value="<?php echo (!empty($id) ? 'Обновить' : 'Создать'); ?>">
                <a href="<?php echo BASE_URL; ?>"><button class="btn btn-primary">Отменить</button></a>
            </div>
        </form>
    </div>

<?php include BASE_DIR . 'App/Views/partials/footer.php'; ?>