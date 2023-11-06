<?php

/** Execute Initialize Database script */
include_once("init_db.php");

/** Enable PHP error reporting */
error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once("controllers/router.php");

$router = new Router("home");
if (isset($_GET['page'])) {
    $router->updatePage($_GET['page']);
}
$router->loadLayout();
