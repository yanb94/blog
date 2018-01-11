<?php
session_start();
session_regenerate_id();

require '../vendor/autoload.php';

use Framework\App;

$app = new App();

$app->run();
