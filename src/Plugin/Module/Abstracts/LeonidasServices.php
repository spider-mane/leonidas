<?php

namespace Leonidas\Plugin\Module\Abstracts;

use Exception;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Plugin\Leonidas;

trait LeonidasServices
{
    public function getService(string $service)
    {
        $extension = $this->getExtension();

        try {
            $service = $extension->get($service);
        } catch (Exception $clientContainerException) {
            try {
                $service = Leonidas::getService($service);
            } catch (Exception) {
                throw $clientContainerException;
            }
        }

        return $service;
    }

    abstract protected function getExtension(): WpExtensionInterface;
}
