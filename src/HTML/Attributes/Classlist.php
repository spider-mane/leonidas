<?php

namespace WebTheory\Html\Attributes;

use WebTheory\Html\Contracts\HtmlAttributeInterface;

class Classlist extends AbstractHtmlAttribute implements HtmlAttributeInterface
{
    /**
     *
     */
    protected $value = [];

    protected const ATTRIBUTE = 'class';

    /**
     *
     */
    public function set($classlist)
    {
        $this->value = $classlist;
    }

    /**
     *
     */
    public function add(string $class)
    {
        $this->value[] = $class;

        return $this;
    }

    /**
     *
     */
    public function remove($class)
    {
        while ($this->contains($class)) {
            unset($this->value[array_search($class, $this->value)]);
        }

        return $this;
    }

    /**
     *
     */
    public function toggle($class)
    {
        if ($this->contains($class)) {
            $this->remove($class);
        } else {
            $this->add($class);
        }

        return $this;
    }

    /**
     *
     */
    public function contains($class)
    {
        return in_array($class, $this->value, false);
    }

    /**
     *
     */
    public function parse(): string
    {
        return implode(' ', $this->value);
    }

    /**
     *
     */
    public function tokenize(string $classlist): array
    {
        return explode(' ', $classlist);
    }
}
