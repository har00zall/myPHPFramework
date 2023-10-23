<?php
namespace Controller;

use Routes\Router;

class Controller
{
    public function __construct()
    {

    }

    public function index()
    {

    }

    public function view($view = '') // return string of path to view
    {
        $view = __DIR__ . '\\..\\App\\Views\\' . $view . '.php';

        if (!file_exists($view)) 
        {
            return Router::$notFoundDefaultPageDir;
        }

        return $view;
    }
}

$controller = new Controller();