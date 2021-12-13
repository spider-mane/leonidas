<?php

namespace Leonidas\Contracts\Ui\Asset;

use Psr\Http\Message\ServerRequestInterface;

interface ScriptLoaderInterface
{
    public function load(ServerRequestInterface $request);

    public static function createScriptTag(ScriptInterface $script): string;

    public static function mergeScriptTag(string $tag, ScriptInterface $script): string;

    public static function registerScript(ScriptInterface $script);

    public static function enqueueScript(ScriptInterface $script);
}
