<?php

use Backalley\Html\Html;
use Backalley\Wordpress\Load\Screen;

#ErrorHandling
// (new Run)->prependHandler(new PrettyPageHandler)->register(); // error handling with whoops

Screen::load('post', ['post_type' => 'ba_location'], function () {
    include 'fields.php';
});
