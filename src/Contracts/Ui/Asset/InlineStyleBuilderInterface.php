<?php

namespace Leonidas\Contracts\Ui\Asset;

use Leonidas\Contracts\Http\ConstrainerCollectionInterface;

interface InlineStyleBuilderInterface
{
    public function handle(string $handle);

    public function code(string $code);

    public function constraints(?ConstrainerCollectionInterface $constraints);

    public function done(): InlineStyleInterface;
}
