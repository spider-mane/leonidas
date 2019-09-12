<?php

namespace Backalley\Form;

use Backalley\GuctilityBelt\Concerns\SmartFactoryTrait;
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
            $rule = $split[0];
            $args = explode(';', $split[1] . ';');

            foreach ($args as $i => $arg) {
                $argSplit = explode('=', $arg);
                $args[Str::camel($argSplit[0])] = $argSplit[1];
                unset($args[$i]);
            }

            $rule = new ReflectionClass($this->getValidator($rule));

            $params = $rule
                ->getConstructor()
                ->getParameters();

            foreach ($params as $param) {
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
