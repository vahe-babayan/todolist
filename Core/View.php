<?php

namespace Core;

class View
{
    public static function render($view, $params = [])
    {
        extract($params, EXTR_SKIP);

        $file = BASE_DIR . 'App/Views/' . $view . '.php';

        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }
    }
}