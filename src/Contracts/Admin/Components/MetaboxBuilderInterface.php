<?php

namespace Leonidas\Contracts\Admin\Components;

use Leonidas\Contracts\Http\ConstrainerCollectionInterface;

interface MetaboxBuilderInterface
{
    public function id(string $id);

    public function title(string $title);

    public function screen($screen);

    public function context(?string $context);

    public function priority(?string $priority);

    public function args(?array $args);

    public function layout(MetaboxLayoutInterface $layout);

    public function constraints(ConstrainerCollectionInterface $constraints);
}
