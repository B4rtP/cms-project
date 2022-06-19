<?php
use Cms\core\Database;
use Cms\core\helpers\SessionHelper;
use Cms\core\View;
use Cms\models\Router;

session_start();

define('ROOT_PATH', dirname(dirname(dirname(__FILE__))). DIRECTORY_SEPARATOR);
define('VIEW_ROOT', ROOT_PATH. 'src/shop/views'. DIRECTORY_SEPARATOR);

require_once ROOT_PATH.'/vendor/autoload.php';
include ROOT_PATH.'src/config/config.php';

//Create shopping cart
SessionHelper::createArray('cart');

// connect to DB and get connection
$DB = Database::getInstance();
$DB->connect('mysql:host='. DB_HOST.';dbname='. DB_NAME, DB_USER, DB_PASS);
$dbConn = $DB->getConnection();

$parsedUrl = explode('/', $_GET['route'] ?? 'shop');

$router = new Router($dbConn);
$routerObj = $router->findBy('url', array_shift($parsedUrl));

$controllerName = ucfirst($routerObj->module). 'Controller';
$actionName = empty($routerObj->action) ? 'index' : $routerObj->action;

if (file_exists(ROOT_PATH. 'src/shop/controllers/'. $controllerName. '.php')) {
    require ROOT_PATH. 'src/shop/controllers/'. $controllerName. '.php';

    $controller = new $controllerName();
    $controller->view = new View('shop-template');
    $controller->dbc = $dbConn;
    $controller->entityId = $routerObj->entity_id;
    $controller->urlParams = array_shift($parsedUrl);
    $controller->runAction($actionName);
}