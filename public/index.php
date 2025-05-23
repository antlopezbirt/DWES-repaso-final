<?php
error_reporting(E_ALL);

require_once(__DIR__ . '/../app/utils/DataHandler.php');
require_once(__DIR__ . '/../app/core/DatabaseSingleton.php');

require_once(__DIR__ . '/../conf/config.php');
include_once(__DIR__ . '/../app/core/Router.php');
include_once(__DIR__ . '/../app/controllers/ItemController.php');
include_once(__DIR__ . '/../app/models/ItemModel.php');
include_once(__DIR__ . '/../app/models/DAO/ItemDAO.php');
include_once(__DIR__ . '/../app/models/entity/ItemEntity.php');
include_once(__DIR__ . '/../app/models/DTO/ItemDTO.php');
include_once(__DIR__ . '/../app/utils/ApiJsonResponse.php');

$url = $_SERVER['REQUEST_URI'];

$router = new Router();

$router->match($url);