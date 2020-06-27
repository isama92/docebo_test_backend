<?php

// required dependancies
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'Api.php');
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'Db.php');

// import configurations
$cfg = include('./config.php');

// instantiate Api
$api = new Api($cfg);

// start elaborating the request
$api->run();
