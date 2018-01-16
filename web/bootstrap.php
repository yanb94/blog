<?php
require '../vendor/autoload.php';
session_name(hash('ripemd160', 'cdb8426cb020896cea1d040e62a0f8cf9f5b4226'));
session_start();
session_regenerate_id(true);

use Framework\App;

$app = new App();

$app->run();
