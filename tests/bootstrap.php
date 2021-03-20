<?php

$root = dirname(__DIR__);

require $root . '/vendor/autoload.php';

WP_Mock::activateStrictMode();
WP_Mock::bootstrap();
