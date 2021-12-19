<?php

namespace Leonidas\Contracts\Ui\Asset;

use Leonidas\Contracts\Http\ConstrainerCollectionInterface;

interface InlineScriptBuilderInterface
{
    public function handle(string $handle): InlineScriptBuilderInterface;

    public function code(string $code): InlineScriptBuilderInterface;

    public function position(string $position): InlineScriptBuilderInterface;

    public function constraints(?ConstrainerCollectionInterface $constraints): InlineScriptBuilderInterface;

    public function done(): InlineScriptInterface;
}
