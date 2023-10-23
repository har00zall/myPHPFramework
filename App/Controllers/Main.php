<?php
require __DIR__ . "\\..\\..\\System\\controller.php";

use Controller\Controller;

class Main extends Controller {

    public function index() 
    {
        return $this->view("main");
    }

    public function user($data)
    {
        return $this->view("main");
    }
}
