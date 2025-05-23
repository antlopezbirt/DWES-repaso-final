<?php
error_reporting(E_ALL);

require_once(__DIR__ . '/../conf/config.php');
include_once(__DIR__ . '/../app/core/Router.php');
include_once(__DIR__ . '/../app/controllers/ItemController.php');
include_once(__DIR__ . '/../app/utils/DataHandler.php');
include_once(__DIR__ . '/../app/models/ItemModel.php');
include_once(__DIR__ . '/../app/utils/ApiJsonResponse.php');

$url = $_SERVER['REQUEST_URI'];

$router = new Router();

$router->match($url);