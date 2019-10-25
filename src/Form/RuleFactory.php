<?php

namespace WebTheory\Form;

use Illuminate\Support\Str;
use ReflectionClass;
use Respect\Validation\Factory;
use Respect\Validation\Rules\AllOf;
use Respect\Validation\Validator;

class RuleFactory
{
    /**
     *
     */
    public function create($args)
    {
        $validator = new AllOf;
        $rules = explode('|', $args . '|');

        foreach ($rules as $rule) {
            $split = explode(':', $rule);
            $rule = new ReflectionClass($this->getValidator($split[0]));
            $args = explode(';', $split[1] . ';');

            foreach ($args as $i => $arg) {
                $argSplit = explode('=', $arg);
                $args[Str::camel($argSplit[0])] = $argSplit[1];
                unset($args[$i]);
            }

            foreach ($rule->getConstructor()->getParameters() as $param) {
                $construct[$param] = $args[$param] ?? null;
            }

            $validator->addRule($rule, ...$construct);
        }

        return $validator;
    }

    /**
     *
     */
    public function getValidator($rule)
    {
        $namespace = (new Factory)->getRulePrefixes();

        foreach ($namespace as $namespace) {
            if (class_exists($validator = 'namespace' . Str::studly($rule))) {
                return $validator;
            }
        }

        throw new \Exception('no such thing');
    }
}
