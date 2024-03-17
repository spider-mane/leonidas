<?php

namespace Leonidas\Framework\Site\Form;

use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validatable;
use WebTheory\Saveyour\Validation\RespectValidator;

trait ValidatesWithRespectMapTrait
{
    protected function validation(ServerRequestInterface $request): array
    {
        $validatables = $this->validatables($request);
        $mapName = fn (Validatable $v, string $rule) => $v->setName($rule);

        foreach ($validatables as &$rules) {
            array_walk($rules, $mapName);

            $rules = new RespectValidator(...array_values($rules));
        }

        return $validatables;
    }

    /**
     * @return array<string,array<string,Validatable>>
     */
    abstract protected function validatables(ServerRequestInterface $request): array;
}
