<?php
require __DIR__ . "\\..\\..\\System\\router.php";

$router->addRoute("//", "Main");
$router->addRoute("/home/", "Main");
$router->addRouteGet("/user/(:any)", "Main:user", "userName");