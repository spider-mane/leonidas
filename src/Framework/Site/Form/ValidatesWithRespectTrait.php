<?php

namespace Leonidas\Framework\Site\Form;

use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validatable;
use WebTheory\Saveyour\Validation\RespectValidator;

trait ValidatesWithRespectTrait
{
    protected function validation(ServerRequestInterface $request): array
    {
        return array_map(
            fn (array $v) => new RespectValidator(...$v),
            $this->validatables($request)
        );
    }

    /**
     * @return array<string,array<Validatable>>
     */
    abstract protected function validatables(ServerRequestInterface $request): array;
}
