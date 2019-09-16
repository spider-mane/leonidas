<?php

namespace Backalley\Wordpress;

abstract class AbstractWpObjectFacade
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var array
     */
    public $args;

    /**
     * @var array
     */
    public $labels;

    /**
     * @var array
     */
    public $rewrite;

    /**
     *
     */
    public const EXALTED_ARGS = ['labels', 'rewrite'];

    /**
     * Get the value of name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the value of args
     *
     * @return mixed
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     * Set the value of args
     *
     * @param array $args
     *
     * @return self
     */
    public function setArgs(array $args)
    {
        $this->args = $args;

        return $this;
    }

    /**
     * Get the value of labels
     *
     * @return mixed
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     *
     */
    public function setLabels(array $labels)
    {
        $this->labels = $labels + $this->getDefaultLabels(
            $labels['singular_name'],
            $labels['name']
        );

        return $this;
    }

    /**
     * Get the value of rewrite
     *
     * @return array
     */
    public function getRewrite(): array
    {
        return $this->rewrite;
    }

    /**
     * Set the value of rewrite
     *
     * @param array $rewrite
     *
     * @return self
     */
    public function setRewrite(array $rewrite)
    {
        $this->rewrite = $rewrite;

        return $this;
    }

    /**
     *
     */
    protected function buildArgs(array $args): array
    {
        foreach ($this::EXALTED_ARGS as $arg) {
            if (!empty($property = $this->{$arg})) {
                $args[$arg] = $property;
            }
        }

        return $args;
    }

    /**
     *
     */
    public function hook()
    {
        add_action('init', [$this, 'register']);

        return $this;
    }

    /**
     *
     */
    abstract protected function getDefaultLabels(string $single, string $plural): array;

    /**
     *
     */
    abstract public function register();
}
