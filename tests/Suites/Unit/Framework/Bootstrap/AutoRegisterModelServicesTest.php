<?php

namespace Tests\Suites\Unit\Framework\Bootstrap;

use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Framework\Bootstrap\AutoRegisterModelServices;
use Panamax\Contracts\ServiceContainerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\Support\UnitTestCase;

class AutoRegisterModelServicesTest extends UnitTestCase
{
    /**
     * @var WpExtensionInterface&MockObject
     */
    protected $extension;

    /**
     * @test
     */
    public function it_boots()
    {
        # Arrange
        $path = '/src/Library/System/Model';

        /** @var WpExtensionInterface&MockObject $extension */
        $extension = $this->createMock(WpExtensionInterface::class);
        $extension->method('absPath')->willReturn($this->root . $path);
        $extension->method('config')->with('app.models')->willReturn($path);

        /** @var ServiceContainerInterface&MockObject $container */
        $container = $this->createMock(ServiceContainerInterface::class);

        $sut = new AutoRegisterModelServices();

        # Act
        $sut->boot($extension, $container);

        # Assert
    }
}
