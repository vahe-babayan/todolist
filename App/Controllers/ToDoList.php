<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use App\Models\ToDoItems;
use App\Models\User;

class ToDoList extends Controller
{
    public $notifications = [
        'created_successfully' => ['type' => 'success', 'content' => 'To Do item created successfully']
    ];

    public function index($params = [])
    {
        $params['is_logged'] = User::isLogged();

        if (!empty($_GET['n'])) {
            $notification_slug = filter_var(trim($_GET['n']), FILTER_SANITIZE_STRING);
            if (!empty($this->notifications[$notification_slug])) {
                $params['notifications'] = [$this->notifications[$notification_slug]];
            }
        }

        if (empty($_SESSION['sort_by'])) {
            $_SESSION['sort_by'] = 'name';
        }
        if (empty($_SESSION['sort_by_order'])) {
            $_SESSION['sort_by_order'] = 'ASC';
        }
        if (!empty($_GET['sort_by'])) {
            $_SESSION['sort_by'] = filter_var(trim($_GET['sort_by']), FILTER_SANITIZE_STRING);
        }
        if (!empty($_GET['sort_by_order'])) {
            $_SESSION['sort_by_order'] = filter_var(trim($_GET['sort_by_order']), FILTER_SANITIZE_STRING);
        }
        $params['sort_by'] = $_SESSION['sort_by'];
        $params['sort_by_order'] = $_SESSION['sort_by_order'];

        $toDoItem = new ToDoItems();

        $params['page'] = (!empty($_GET['page']) ? (int)$_GET['page'] : 1);
        $offset = (!empty($params['page']) ? ((int)$params['page'] - 1) * 3 : 0);
        
        $params['toDoList'] = $toDoItem->getItems(3, $offset, $_SESSION['sort_by'], $_SESSION['sort_by_order']);
        $params['itemsTotal'] = (int)$toDoItem->getTotalCount()['items_total'];
        
        $params['pagesTotal'] = ceil($params['itemsTotal']/3);

        View::render('ToDoList', $params);
    }

    public function create()
    {
        View::render('ToDoAddNew');
    }

    public function edit()
    {
        if (!User::isLogged()) {
            header('Location: ' . BASE_URL);
            exit();
        }

        $url_params = $_GET['p'];

        $id = (!empty($url_params['item_id']) ? (int)$url_params['item_id'] : null);

        if (!$id) {
            header('Location: ' . BASE_URL);
            exit();
        } else {
            $toDoItem = new ToDoItems($id);

            $params = [
                'id' => $toDoItem->id,
                'name' => $toDoItem->name,
                'email' => $toDoItem->email,
                'task' => $toDoItem->task,
                'status' => $toDoItem->status,
            ];

            View::render('ToDoAddNew', $params);
        }
    }

    public function save()
    {
        $errors = [];
        $id = (int)$_POST['id'];

        if ($id && !User::isLogged()) {
            header('Location: ' . BASE_URL . '?c=Login');
            exit();
        }

        $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
        $email = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));
        $task = trim(filter_input(INPUT_POST, 'task', FILTER_SANITIZE_STRING));
        $status = (isset($_POST['status']) ? filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT) : 0);

        if (!$name) {
            $errors[] = 'Неправильное имя';
        }
        if (!$email) {
            $errors[] = 'Неправильное адрес электронной почты';
        }
        if (!$task) {
            $errors[] = 'Неправильное текст задачи';
        }

        if ($errors) {
            $params = [
                'errors' => $errors,
                'id' => $id,
                'name' => $name,
                'email' => trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING)),
                'task' => $task,
                'status' => $status
            ];

            View::render('ToDoAddNew', $params);
        } else {
            $toDoItem = new ToDoItems($id);
            $toDoItem->name = $name;
            $toDoItem->email = $email;

            if ($id && $toDoItem->task !== $task) {
                $toDoItem->edit_by_admin = 1;
            }

            $toDoItem->task = $task;
            $toDoItem->status = $status;
            $toDoItem->save();

            header('Location: ' . BASE_URL . '?c=ToDoList&n=created_successfully');
            exit();
        }
    }
}
