<?php

namespace Leonidas\Traits;

use Psr\Http\Message\ServerRequestInterface;
use Leonidas\Contracts\Auth\ConstrainerInterface;

trait CanBeRestrictedTrait
{
    /**
     * @var ConstrainerInterface[]
     */
    protected $constraints = [];

    /**
     * Get the value of constraints
     *
     * @return array|ConstrainerInterface[]
     */
    public function getConstraints()
    {
        return $this->constraints;
    }

    /**
     * Set the value of constraints
     *
     * @param ConstrainerInterface[] $constraints
     *
     * @return self
     */
    public function setConstraints(ConstrainerInterface ...$constraints)
    {
        $this->constraints = $constraints;

        return $this;
    }

    /**
     * Set the value of constraints
     *
     * @param ConstrainerInterface $constraint
     *
     * @return self
     */
    public function addConstraint(ConstrainerInterface $constraint)
    {
        $this->constraints[] = $constraint;

        return $this;
    }

    /**
     *
     */
    public function shouldBeRendered(ServerRequestInterface $request): bool
    {
        foreach ($this->constraints as $constraint) {
            if (!$constraint->requestMeetsCriteria($request)) {
                return false;
            }
        }

        return true;
    }
}
