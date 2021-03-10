<?php

use Leonidas\Library\Core\PostType\Factory as PostTypeFactory;
use Leonidas\Library\Core\Taxonomy\Factory as TaxonomyFactory;

################################################################################


$app = require 'config/app.php';
$postTypeHandlers = $app['option_handlers']['post_type'];
$taxonomyHandlers = $app['option_handlers']['taxonomy'];

$postTypes = require 'config/post_types.php';
$taxonomies = require 'config/taxonomies.php';

$postTypes = (new PostTypeFactory($postTypeHandlers))->create($postTypes);
$taxonomies = (new TaxonomyFactory($taxonomyHandlers))->create($taxonomies);
