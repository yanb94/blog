<?php
require '../vendor/autoload.php';

session_start();
session_regenerate_id();

use Framework\App;

$app = new App();

$app->run();
