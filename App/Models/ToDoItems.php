<?php

namespace App\Models;

use Core\Model;
use Core\DB;

class ToDoItems extends Model
{
    public $id;
    public $name;
    public $email;
    public $task;
    public $status;
    public $edit_by_admin;
    public $created_at;

    public function __construct($id = null)
    {
        if ($id) {
            $this->id = (int)$id;

            $sql = sprintf('SELECT id, name, email, task, status, edit_by_admin, created_at FROM todolist WHERE id=%d LIMIT 1', $this->id);

            $item = DB::getInstance()->query($sql)->fetch_assoc();

            $this->name = $item['name'];
            $this->email = $item['email'];
            $this->task = $item['task'];
            $this->status = $item['status'];
            $this->edit_by_admin = $item['edit_by_admin'];
        }
    }

    public function getItems($limit = null, $offset = 0, $sort_by = 'name', $sort_by_order = 'ASC')
    {
        $sql = sprintf('SELECT id, name, email, task, status, edit_by_admin, created_at FROM todolist ORDER BY %s %s', $sort_by, $sort_by_order);

        if ($limit) {
            $sql .= sprintf(' LIMIT %d OFFSET %d', $limit, $offset);
        }

        return DB::getInstance()->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalCount()
    {
        return DB::getInstance()->query('SELECT COUNT(id) AS items_total FROM todolist')->fetch_assoc();
    }

    public function save()
    {
        if ($this->id) {
            $stmt = DB::getInstance()->prepare('UPDATE todolist SET name=?, email=?, task=?, status=?, edit_by_admin=? WHERE id=?');
            $stmt->bind_param("sssiii", $this->name, $this->email, $this->task, $this->status, $this->edit_by_admin, $this->id);
        } else {
            $stmt = DB::getInstance()->prepare('INSERT INTO todolist (name, email, task, status) VALUES (?, ?, ?, ?)');
            $stmt->bind_param("sssi", $this->name, $this->email, $this->task, $this->status);
        }

        $stmt->execute();
    }
}
