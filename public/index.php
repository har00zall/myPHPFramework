<?php
require "../App/Config/configs.php";
require "../App/Config/routes.php";

// disable cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$request = $_SERVER["REQUEST_URI"];
if (str_ends_with($request, '/') == false) $request .= '/';

$router->route($request);