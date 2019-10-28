<?php

namespace WebTheory\Voltaire;

class TemplateRouter
{
    /**
     *
     */
    protected $dir;

    /**
     *
     */
    protected $routes = [
        'index', '404', 'archive', 'author', 'category', 'tag', 'taxonomy',
        'date', 'embed', 'home', 'frontpage', 'page', 'paged', 'search',
        'single', 'singular', 'attachment',
    ];

    /**
     *
     */
    protected function __construct(string $dir)
    {
        $this->dir = $dir;
    }

    /**
     *
     */
    protected function hook()
    {
        foreach ($this->routes as $route) {

            add_filter("{$route}_template_hierarchy", [$this, 'redirect'], PHP_INT_MAX, 1);
        }

        return $this;
    }

    /**
     *
     */
    public function redirect($templates)
    {
        foreach ((array) $templates as $i => $template) {
            $templates[$i] = "{$this->dir}/{$template}";
        }

        return $templates;
    }

    /**
     *
     */
    public static function set(string $dir)
    {
        return (new static($dir))->hook();
    }
}
