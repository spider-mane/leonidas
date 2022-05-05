<?php

namespace Leonidas\Library\Admin\Processing;

use WebTheory\Saveyour\Contracts\Formatting\InputFormatterInterface;
use WebTheory\Saveyour\Contracts\Validation\ValidatorInterface;

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
        $result = $this->validator->inspect($input);

        if (true === $result->validationStatus()) {
            return $this->formatter->formatInput($input);
        }

        foreach ($result->ruleViolations() as $violation) {
            $this->handleRuleViolation($violation);
        }

        return $this->returnIfFailed();
    }

    abstract protected function returnIfFailed();

    abstract protected function handleRuleViolation($rule): void;
}
