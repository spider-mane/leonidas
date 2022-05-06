<?php

namespace Leonidas\Library\Core\Hook\Action;

use Leonidas\Contracts\Hook\HookInterface;
use Leonidas\Contracts\Hook\ListenerInterface;
use Psr\EventDispatcher\ListenerProviderInterface;

class ListenerProvider implements ListenerProviderInterface
{
    /**
     * @var array<int,ListenerInterface>
     */
    protected array $listeners = [];

    public function addListener(ListenerInterface $listener)
    {
        $this->listeners[$listener->getFeatureGroup()] = $listener;
    }

    public function getListenersForEvent(object $hook): iterable
    {
        $listeners = [];

        foreach ($this->listeners as $listener) {
            if ($this->shouldRunListener($hook, $listener)) {
                $listeners[] = $listener->getCallback();
            }
        }

        return $listeners;
    }

    protected function shouldRunListener(HookInterface $hook, ListenerInterface $listener): bool
    {
        $listenerMatchesTag = $hook->getTag() === $listener->getHookTag();

        return $listenerMatchesTag;
    }
}
