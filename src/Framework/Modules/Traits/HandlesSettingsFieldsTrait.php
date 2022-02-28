<?php

namespace Leonidas\Framework\Modules\Traits;

use Closure;
use Leonidas\Contracts\Admin\Components\SettingsFieldCollectionInterface;
use Leonidas\Contracts\Admin\Components\SettingsFieldLoaderInterface;
use Leonidas\Library\Admin\Page\SettingsField\SettingsFieldLoader;
use Psr\Http\Message\ServerRequestInterface;

trait HandlesSettingsFieldsTrait
{
    use AbstractModuleTraitTrait;

    protected function registerSettingsFields(ServerRequestInterface $request)
    {
        $this->settingsFieldLoader()->registerMany(
            $this->getSettingsFields(),
            $request
        );
    }

    protected function renderSettingsField(array $args): void
    {
        $request = $this->getServerRequest()->withAttribute('args', $args);

        echo $this->getSettingsFields()
            ->get($args['@base'])
            ->renderComponent($request);
    }

    protected function settingsFieldLoader(): SettingsFieldLoaderInterface
    {
        return new SettingsFieldLoader(
            Closure::fromCallable([$this, 'renderSettingsField'])
        );
    }

    abstract protected function getSettingsFields(): SettingsFieldCollectionInterface;
}
