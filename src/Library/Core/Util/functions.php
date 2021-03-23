<?php

namespace Leonidas\Library\Core\Util;

use Leonidas\Library\Core\Exceptions\ScriptNotRegisteredException;
use Leonidas\Library\Core\Exceptions\StyleNotRegisteredException;

function on_dependency_init(array $actions, callable $function): void
{
    $callback = function () use ($actions, $function) {
        static $triggered;
        $triggered = [];
        $triggered[] = current_action();

        if (!array_diff($actions, $triggered)) {
            $function();
        }
    };

    foreach ($actions as $action) {
        add_action($action, $callback);
    }
}

function load_scripts(string ...$scripts): void
{
    foreach ($scripts as $script) {
        if (wp_script_is($script, 'registered')) {
            wp_enqueue_script($script);
        }

        throw new ScriptNotRegisteredException($script);
    }
}

function load_styles(string ...$styles): void
{
    foreach ($styles as $style) {
        if (wp_style_is($style, 'registered')) {
            wp_enqueue_style($style);
        }

        throw new StyleNotRegisteredException($style);
    }
}

function infer_object_properties($object_type)
{
    switch ($object_type) {
        case 'post':
            $object_id = 'ID';
            $object_parent = 'post_parent';
            break;
        case 'term':
            $object_id = 'term_id';
            $object_parent = 'parent';
            break;
    }

    return ['object_id' => $object_id, 'object_parent' => $object_parent];
}

function return_json($status)
{
    $return = [
        'status' => $status,
    ];

    wp_send_json($return);

    wp_die();
}

function json_encode_wp_safe($input, bool $slashes = true)
{
    $input = json_encode($input, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    if ($slashes) {
        $input = wp_slash($input);
    }

    return $input;
}
