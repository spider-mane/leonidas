<?php

use function DeepCopy\deep_copy;

add_filter('timber/twig', function ($twig) {
    return $twig;
});
