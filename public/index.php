<?php
session_start();

use Cms\core\Database;
use Cms\core\View;
use Cms\models\Router;

define('ROOT_PATH', dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR);
define('VIEW_ROOT', ROOT_PATH. 'src/views'. DIRECTORY_SEPARATOR);

require_once ROOT_PATH.'/vendor/autoload.php';
include ROOT_PATH.'src/config/config.php';

$DB = Database::getInstance();
$DB->connect('mysql:host='. DB_HOST.';dbname='. DB_NAME, DB_USER, DB_PASS);
$dbConnection = $DB->getConnection();

// Parse URL
$parsedUrl = explode('/', $_GET['route'] ?? 'home');

// Find route in DB based on the url first param
$router = new Router($dbConnection);
$routerObj = $router->findBy('url', array_shift($parsedUrl));

// Get module, action and params
$controllerName = ucfirst($routerObj->module). 'Controller';
$actionName = array_shift($parsedUrl) ?? 'index';

if (file_exists(ROOT_PATH. 'src/controllers/'. $controllerName. '.php')) {
    require ROOT_PATH. 'src/controllers/'. $controllerName. '.php';

    $controller = new $controllerName();
    $controller->view = new View('default-template');
    $controller->entityId = $routerObj->entity_id;
    $controller->dbc = $dbConnection;
    $controller->urlParams = $parsedUrl;
    $controller->runAction($actionName);
}




