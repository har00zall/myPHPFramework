<?php
namespace Routes;

class RouteFormat
{
    public $controllerFileDIR;
    public $className;
    public $methodName;

    public function __construct($controllerFileDIR, $className, $methodName)
    {
        $this->controllerFileDIR = $controllerFileDIR;
        $this->className = $className;
        $this->methodName = $methodName;
    }
}

class Router
{
    public $routes;
    public static $notFoundDefaultPageDir = __DIR__ . '\\Default\\404.php';

    public function addRoute($from, $to)
    {
        if (strpos($to, ':') == false) $to = $to . ":index";

        $classAndMethod = explode(':', $to);
        // print_r($classAndMethod);

        $classController = $classAndMethod[0];
        $methodController = $classAndMethod[1];
        $controllerDir = __DIR__ . '\\..\\App\\Controllers\\' . $classController . '.php';

        if (!file_exists($controllerDir)) return;

        $newRoute = new RouteFormat($controllerDir, $classController, $methodController);

        $this->routes[$from] = $newRoute;
        // print_r($this->routes);
    }

    public function addRouteGet($from, $to, $getData)
    {
        $this->addRoute($from, $to);
    }

    public function route($from)
    {
        if (!isset($from)) 
        {
            $this->show404Page();
            return;
        }

        $urisFrom = explode('/', $from);
        $mainURI = '/' . $urisFrom[1] . '/';
        $args = array();
        if (count($urisFrom) > 3)
        {
            for ($i = 2; $i < count($urisFrom); $i++)
            {
                if ($urisFrom[$i] == '') continue;
                array_push($args, $urisFrom[$i]);
            }
        }
        // print_r($args);
        // echo $mainURI;
        if (!isset($this->routes[$mainURI])) {

            $this->show404Page();

            return;
        }

        $finalURI = $mainURI . (count($args) > 0 ? '(:any)' : '');
        
        // echo $finalURI;

        $localRoute = $this->routes[$finalURI];
        require $localRoute->controllerFileDIR;

        if (class_exists($localRoute->className)) {
            $myPage = new $localRoute->className();
            $methodName = $localRoute->methodName;
            
            if (count($args) == 0) require $myPage->$methodName();
            else 
            {
                if (method_exists($myPage, $methodName))
                {
                    require $myPage->$methodName($args);
                }
            }
        } else {
            $this->show404Page();
        }
    }

    public static function show404Page()
    {
        require_once self::$notFoundDefaultPageDir;
    }
}

$router = new Router();