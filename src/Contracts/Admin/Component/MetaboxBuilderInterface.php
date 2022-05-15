<?php

namespace Leonidas\Contracts\Admin\Component;

use WebTheory\HttpPolicy\ServerRequestPolicyInterface;

interface MetaboxBuilderInterface
{
    public function id(string $id);

    public function title(string $title);

    public function screen($screen);

    public function context(?string $context);

    public function priority(?string $priority);

    public function args(?array $args);

    public function layout(MetaboxLayoutInterface $layout);

    public function policy(ServerRequestPolicyInterface $policy);
}
