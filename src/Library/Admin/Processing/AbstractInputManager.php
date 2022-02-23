<?php

namespace Leonidas\Library\Admin\Processing;

use WebTheory\Saveyour\Contracts\InputFormatterInterface;
use WebTheory\Saveyour\Contracts\ValidatorInterface;

abstract class AbstractInputManager
{
    protected ValidatorInterface $validator;

    protected InputFormatterInterface $formatter;

    public function __construct(ValidatorInterface $validator, InputFormatterInterface $formatter)
    {
        $this->validator = $validator;
        $this->formatter = $formatter;
    }

    public function handleInput($input)
    {
        $result = $this->validator->validate($input);

        if (true === $result->getStatus()) {
            return $this->formatter->formatInput($input);
        }

        foreach ($result->getViolations() as $violation) {
            $this->handleRuleViolation($violation);
        }

        return $this->returnIfFailed();
    }

    abstract protected function returnIfFailed();

    abstract protected function handleRuleViolation($rule): void;
}
