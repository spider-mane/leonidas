<?php

namespace Leonidas\Contracts\Ui\Asset;

use Leonidas\Contracts\Http\ConstrainerCollectionInterface;

interface InlineStyleBuilderInterface
{
    public function handle(string $handle): InlineStyleBuilderInterface;

    public function code(string $code): InlineStyleBuilderInterface;

    public function constraints(?ConstrainerCollectionInterface $constraints): InlineStyleBuilderInterface;

    public function done(): InlineStyleInterface;
}
