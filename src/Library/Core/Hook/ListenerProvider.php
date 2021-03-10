<?php

namespace Leonidas\Library\Core\Hook;

use Psr\EventDispatcher\ListenerProviderInterface;
use Leonidas\Contracts\Hook\HookInterface;
use Leonidas\Contracts\Hook\ListenerInterface;

class ListenerProvider implements ListenerProviderInterface
{
    /**
     * @var ListenerInterface[]
     */
    protected $listeners;

    /**
     *
     */
    public function addListener(ListenerInterface $listener)
    {
        $this->listeners[$listener->getFeatureGroup()] = $listener;
    }

    /**
     *
     */
    public function getListenersForEvent(HookInterface $hook): iterable
    {
        $listeners = [];

        foreach ($this->listeners as $listener) {
            if ($this->shouldRunListener($hook, $listener)) {
                $listeners[] = $listener;
            }
        }

        return $listeners;
    }

    /**
     *
     */
    protected function shouldRunListener(HookInterface $hook, ListenerInterface $listener): bool
    {
        $listenerMatchesTag = $hook->getTag() === $listener->getHookTag();

        return $listenerMatchesTag;
    }
}
