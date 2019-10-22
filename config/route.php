<?php

/**
 * Класс маршрутизации
 * Class Routing
 */
class Routing
{
    /**
     *
     */
    public static function buildRoute()
    {
        /*Controller и Action по умолчанию*/
        $controllerName = "IndexController";
        $modelName = "IndexModel";
        $action = "index";

        $route = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        /*Определяем Controller и Action*/
        $num = count($route);
        $i = 0;
        while($i<$num) {
            if($route[$i] != '') {
                if(is_file(CONTROLLER_PATH . ucfirst($route[$i]) . "Controller.php")) {
                    $controllerName = ucfirst($route[$i]) . "Controller";
                    $modelName =  ucfirst($route[$i]) . "Model";
                    $i++;
                    if ($route[$i] != '')
                        $action = $route[$i];
                    break;
                } else {
                    $action = $route[$i];
                }
            }
            $i++;
        }
        require_once CONTROLLER_PATH . $controllerName . ".php";
        require_once MODEL_PATH . $modelName . ".php";

        $controller = new $controllerName();
        $controller->$action();
    }

    public function errorPage()
    {

    }
}