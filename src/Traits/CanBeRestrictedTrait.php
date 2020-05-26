<?php

namespace WebTheory\Leonidas\Traits;

use WP_Post;
use WebTheory\Leonidas\Contracts\ComponentConstrainerInterface;

trait CanBeRestrictedTrait
{
    /**
     * @var ComponentConstrainerInterface[]
     */
    protected $constraints = [];

    /**
     * Get the value of constraints
     *
     * @return array|ComponentConstrainerInterface[]
     */
    public function getConstraints()
    {
        return $this->constraints;
    }

    /**
     * Set the value of constraints
     *
     * @param ComponentConstrainerInterface[] $constraints
     *
     * @return self
     */
    public function setConstraints(ComponentConstrainerInterface ...$constraints)
    {
        $this->constraints = $constraints;

        return $this;
    }

    /**
     * Set the value of constraints
     *
     * @param ComponentConstrainerInterface $constraint
     *
     * @return self
     */
    public function addConstraint(ComponentConstrainerInterface $constraint)
    {
        $this->constraints[] = $constraint;

        return $this;
    }

    /**
     *
     */
    protected function shouldLoad(WP_Post $post): bool
    {
        foreach ($this->constraints as $constraint) {
            if (!$constraint->loadComponentForPost($post)) {
                return false;
            }
        }

        return true;
    }
}
