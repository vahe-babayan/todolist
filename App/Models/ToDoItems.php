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

            $sql = 'SELECT id, name, email, task, status, edit_by_admin, created_at FROM todolist WHERE id=' . $this->id . ' LIMIT 1';

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
        $sql = 'SELECT id, name, email, task, status, edit_by_admin, created_at FROM todolist ORDER BY ' . $sort_by . ' ' . $sort_by_order;

        if ($limit) {
            $sql .= ' LIMIT ' . $limit . ' OFFSET ' . $offset;
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
            $sql = 'UPDATE todolist
                    SET name=\'' .  $this->name . '\', email=\'' .  $this->email . '\', task=\'' .  $this->task . '\', status=\'' .  $this->status . '\', edit_by_admin=\'' .  $this->edit_by_admin . '\'
                    WHERE id=' . $this->id;
        } else {
            $sql = 'INSERT INTO todolist (name, email, task, status)
                    VALUES (\'' . $this->name . '\', \'' . $this->email . '\', \'' . $this->task . '\', \'' . $this->status . '\')';
        }

        DB::getInstance()->query($sql);
    }
}
