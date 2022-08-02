<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use App\Models\User;

class Login extends Controller
{
    private $username = 'admin';
    private $password;

    public function __construct()
    {
        $this->password = password_hash('123', PASSWORD_BCRYPT);
    }

    public function index()
    {
        if (User::isLogged()) {
            header('Location: ' . BASE_URL);
            exit();
        }

        View::render('Login');
    }

    public function signIn()
    {
        $errors = [];
        $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
        $password = filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW);

        if (!$username || !$password) {
            $errors[] = 'Поля обязательны для заполнения';
        }

        if (!$errors) {
            if ($username !== $this->username || !password_verify($password, $this->password)) {
                $errors[] = 'Введенные данные не верные';
            } else {
                $_SESSION['user'] = true;
                $_SESSION['username'] = $this->username;

                header('Location: ' . BASE_URL);
                exit();
            }
        }

        if ($errors) {
            $params = [
                'errors' => $errors,
                'username' => $username
            ];

            View::render('Login', $params);
        }
    }

    public function logout()
    {
        unset($_SESSION['user']);
        unset($_SESSION['username']);

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();

        header('Location: ' . BASE_URL);
        exit();
    }
}
