<?php

namespace Leonidas\Framework\Module\Abstracts\Traits;

use Closure;
use Leonidas\Contracts\Admin\Component\SettingsField\SettingsFieldCollectionInterface;
use Leonidas\Contracts\Admin\Registrar\SettingsFieldRegistrarInterface;
use Leonidas\Library\Admin\Registrar\SettingsFieldRegistrar;
use Psr\Http\Message\ServerRequestInterface;

trait HandlesSettingsFieldsTrait
{
    use AbstractModuleTraitTrait;

    protected function registerSettingsFields(ServerRequestInterface $request)
    {
        $this->settingsFieldRegistrar()->registerMany(
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

    protected function settingsFieldRegistrar(): SettingsFieldRegistrarInterface
    {
        return new SettingsFieldRegistrar(
            Closure::fromCallable([$this, 'renderSettingsField'])
        );
    }

    abstract protected function getSettingsFields(): SettingsFieldCollectionInterface;
}
