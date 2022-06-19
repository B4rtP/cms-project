<?php
session_start();

use Cms\core\Database;
use Cms\core\View;

define('ROOT_PATH', dirname(dirname(dirname(__FILE__))). DIRECTORY_SEPARATOR);
define('VIEW_ROOT', ROOT_PATH. 'src/admin/views/');

require_once ROOT_PATH.'vendor/autoload.php';
require_once ROOT_PATH. 'src/config/config.php';

$DB = Database::getInstance();
$DB->connect('mysql:host='. DB_HOST.';dbname='. DB_NAME, DB_USER, DB_PASS);
$dbConnection = $DB->getConnection();

$section = $_GET['section'] ?? 'dashboard';
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? '';

// Check if user is admin to prevent direct access from URL
if(!isset($_SESSION['admin'])) {
    $section = 'dashboard';
    $action = 'index';
}

$controllerName = ucfirst($section). 'Controller';

if(file_exists(ROOT_PATH. 'src/admin/controllers/'. $controllerName.'.php')) {

    require ROOT_PATH. 'src/admin/controllers/'. $controllerName.'.php';
    $controller = new $controllerName();
    $controller->view = new View('admin-default');
    $controller->dbc = $dbConnection;
    $controller->id = $id;
    $controller->runAction($action);
}