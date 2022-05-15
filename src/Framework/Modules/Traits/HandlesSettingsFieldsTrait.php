<?php

namespace Leonidas\Framework\Modules\Traits;

use Closure;
use Leonidas\Contracts\Admin\Component\SettingsFieldCollectionInterface;
use Leonidas\Contracts\Admin\Component\SettingsFieldRegistrarInterface;
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
