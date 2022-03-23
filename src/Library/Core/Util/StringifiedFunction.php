<?php

namespace Leonidas\Library\Core\Util;

class StringifiedFunction
{
    /**
     * @var callable
     */
    protected $function;

    protected array $args = [];

    protected bool $buffer = false;

    public function __construct(callable $function, array $args = [], bool $buffer = false)
    {
        $this->function = $function;
        $this->args = $args;
        $this->buffer = $buffer;
    }

    public function __toString()
    {
        return $this->__invoke();
    }

    public function __invoke()
    {
        return $this->call(...func_get_args());
    }

    public function call(...$args)
    {
        $args = $this->parseArgs($args);

        return $this->buffer
            ? $this->bufferedInvocation($args)
            : call_user_func_array($this->function, $args);
    }

    protected function parseArgs(array $args)
    {
        $resolved = $this->args;
        $default = reset($resolved);

        foreach ($args as $index => $arg) {
            $resolved[$index] = $arg ?? $default;
            $default = next($resolved);
        }

        return $resolved;
    }

    protected function bufferedInvocation(array $args): string
    {
        ob_start();

        call_user_func_array($this->function, $args);

        return ob_get_clean();
    }
}
