<?php

namespace Leonidas\Hooks;

trait TargetsAddedTermRelationshipHook
{
    protected function targetAddedTermRelationshipHook()
    {
        add_action(
            'added_term_relationship',
            $this->doAddedTermRelationshipAction(...),
            10,
            PHP_INT_MAX
        );

        return $this;
    }

    abstract protected function doAddedTermRelationshipAction(int $objectId, int $ttId, string $taxonomy): void;
}
