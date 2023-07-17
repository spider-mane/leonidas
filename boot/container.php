<?php

use League\Container\Container;
use Panamax\Adapters\League\LeagueAdapter;

defined('ABSPATH') || exit;

return new LeagueAdapter(new Container());
