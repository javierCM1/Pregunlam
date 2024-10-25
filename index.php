<?php

session_start();
include_once("configuration/Configuration.php");
$configuration = new Configuration();
$router = $configuration->getRouter();

$methodName = isset($_GET['action']) ? $_GET['action'] : 'index';
$router->route($_GET['page'], $methodName);