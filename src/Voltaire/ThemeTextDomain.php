<?php

namespace WebTheory\Voltaire;

class ThemeTextDomain
{
    /**
     *
     */
    public $domain;

    /**
     *
     */
    public $path;

    /**
     *
     */
    protected function __construct(string $domain, string $path)
    {
        $this->domain = $domain;
        $this->path = $path;
    }

    /**
     *
     */
    protected function hook()
    {
        add_action('after_theme_setup', [$this, 'register']);
    }

    /**
     *
     */
    public function register()
    {
        load_theme_textdomain($this->domain, $this->path);
    }

    /**
     *
     */
    public static function set(string $domain, string $path)
    {
        return (new static($domain, $path))->hook();
    }
}
