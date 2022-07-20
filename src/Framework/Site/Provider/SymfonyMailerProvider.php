<?php

namespace Leonidas\Framework\Site\Provider;

use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport\Smtp\SmtpTransport;
use Symfony\Component\Mailer\Transport\Smtp\Stream\AbstractStream;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class SymfonyMailerProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): MailerInterface
    {
        return new Mailer(
            $this->getTransport($container, $args),
            $this->getMessageBus($container, $args),
            $this->getEventDispatcher($container, $args),
        );
    }

    protected function getTransport(ContainerInterface $container, array $args = []): TransportInterface
    {
        $service = $args['$transport'] ?? TransportInterface::class;

        return $container->has($service)
            ? $container->get($service)
            : $this->defaultTransport($container, $args);
    }

    public function defaultTransport(ContainerInterface $container, array $args): TransportInterface
    {
        return new SmtpTransport(
            $this->getStream($container, $args),
            $this->getEventDispatcher($container, $args),
            $this->getLogger($container, $args)
        );
    }

    protected function getMessageBus(ContainerInterface $container, array $args = []): ?MessageBusInterface
    {
        return $this->fetch(
            $args['$message_bus'] ?? MessageBusInterface::class,
            $container
        );
    }

    protected function getEventDispatcher(ContainerInterface $container, array $args = []): ?EventDispatcherInterface
    {
        return $this->fetch(
            $args['$event_dispatcher'] ?? EventDispatcherInterface::class,
            $container
        );
    }

    protected function getStream(ContainerInterface $container, array $args = []): ?AbstractStream
    {
        return $this->fetch(
            $args['$stream'] ?? AbstractStream::class,
            $container
        );
    }

    protected function getLogger(ContainerInterface $container, array $args = []): ?LoggerInterface
    {
        return $this->fetch(
            $args['$logger'] ?? LoggerInterface::class,
            $container
        );
    }
}
