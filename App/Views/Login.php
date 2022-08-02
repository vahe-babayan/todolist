<?php include BASE_DIR . 'App/Views/partials/header.php'; ?>

<body class="page-login">

    <div id="wrapper">
        <form action="<?php echo BASE_URL; ?>?c=login&a=signIn" method="POST">
            <?php if (!empty($errors)) : ?>
            <div class="errors">
                <div class="p-2 mb-3 bg-danger text-white rounded">
                    <?php for ($i = 0, $ci = count($errors); $i < $ci; $i++) : ?>
                    <p class="mb-0"><?php echo $i + 1; ?>. <?php echo $errors[$i]; ?></p>
                    <?php endfor; ?>
                </div>
            </div>
            <?php endif; ?>

            <div class="mb-3 row">
                <label for="username" class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="username" name="username"<?php echo (!empty($username) ? ' value="'.$username.'"' : '') ?>>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="password" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="password" name="password">
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col d-flex">
                    <button type="submit" class="btn btn-primary ms-auto">Войти</button>
                </div>
            </div>
        </form>
    </div>

<?php include BASE_DIR . 'App/Views/partials/footer.php'; ?>