<?php

namespace App\Models;

use Core\Model;

class User extends Model
{
    public static function isLogged()
    {
        return !empty($_SESSION['user']) && $_SESSION['user'] === true;
    }
}