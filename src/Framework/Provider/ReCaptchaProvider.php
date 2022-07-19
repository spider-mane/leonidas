<?php

namespace Leonidas\Framework\Provider;

use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;
use ReCaptcha\ReCaptcha;

class ReCaptchaProvider extends AbstractServiceFactory
{
    public function create(ContainerInterface $container, array $args = []): ReCaptcha
    {
        return new ReCaptcha($args['secret']);
    }
}
