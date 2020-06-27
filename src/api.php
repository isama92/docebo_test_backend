<?php

/** required dependancies */

// main class
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'Api.php');

// db class
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'Db.php');

// request class
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'Request.php');

// function helpers
require_once('./helpers.php');

// import configurations
$cfg = include('./config.php');


/** instantiate and run */

// instantiate Api
$api = new Api($cfg);

// run the api
$api->run();
