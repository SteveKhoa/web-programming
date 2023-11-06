<?php

/** Execute Initialize Database script */
include_once("init_db.php");

include_once("controllers/router.php");
$router = new Router("home");
if (isset($_GET['page'])) {
    $router->updatePage($_GET['page']);
}
$router->loadLayout();
