<?php

use League\Container\Container;
use Panamax\Adapters\League\LeagueAdapter;

defined('ABSPATH') || exit;

$container = new Container();

return new LeagueAdapter($container);
