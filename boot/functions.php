<?php

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

$root ??= dirname(__DIR__, 1);

$loader = fn (SplFileInfo $file) => require $file->getPathname();
$filter = fn (SplFileInfo $file) => 'php' === $file->getExtension();
$finder = fn (string $dir) => array_values(iterator_to_array(
    Finder::create()->filter($filter)->files()->in("{$root}/src/{$dir}")
));

array_map($loader, [
    ...$finder('Plugin/Functions'),
]);
