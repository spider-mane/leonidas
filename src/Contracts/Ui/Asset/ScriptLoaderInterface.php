<?php

namespace Leonidas\Contracts\Ui\Asset;

use Psr\Http\Message\ServerRequestInterface;

interface ScriptLoaderInterface
{
    public function load(
        ScriptCollectionInterface $scripts,
        ServerRequestInterface $request
    );

    public function support(
        InlineScriptCollectionInterface $scripts,
        ServerRequestInterface $request
    );

    public function localize(
        ScriptLocalizationCollectionInterface $localizations,
        ServerRequestInterface $request
    );

    public function activate(string ...$scripts);

    public function deactivate(string ...$scripts);
}
