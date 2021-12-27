<?php

namespace Leonidas\Framework\Providers\League;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Swift_Mailer;
use Swift_SmtpTransport;

class SwiftMailerServiceProvider extends AbstractServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function provides(string $id): bool
    {
        return in_array($id, [Swift_Mailer::class]);
    }

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $container = $this->getContainer();

        $container->add(Swift_Mailer::class, function () use ($container) {
            $config = $container->get('config')->get('mail');

            $transport = (new Swift_SmtpTransport($config['host'], $config['port']))
                ->setUsername($config['username'])
                ->setPassword($config['password']);

            return new Swift_Mailer($transport);
        })->addTag('mailer');
    }
}
