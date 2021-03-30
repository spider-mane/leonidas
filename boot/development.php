<?php

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

ini_set('display_errors', '1');

(new Run())->prependHandler(new PrettyPageHandler())->register();

define('LEONIDAS_DEVELOPMENT', 1);
