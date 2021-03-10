<?php

namespace Leonidas\Tests\Admin\Ui\Metabox;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use WP_Screen;
use WebTheory\Leonidas\Contracts\Admin\Components\MetaboxInterface;
use WebTheory\Leonidas\Contracts\Admin\Components\MetaboxLayoutInterface;
use WebTheory\Leonidas\Library\Admin\Enum\MetaboxContext;
use WebTheory\Leonidas\Library\Admin\Enum\MetaboxPriority;
use WebTheory\Leonidas\Library\Admin\Metabox\Metabox;

class MetaboxTest extends TestCase
{
    /**
     * @var Metabox
     */
    protected $metabox;

    protected function setUp(): void
    {
        $layout = $this->getMockBuilder(MetaboxLayoutInterface::class)
            ->getMock();

        $this->metabox = new Metabox('id', 'title', $layout);
    }

    /**
     * @test
     */
    public function testIsConstructable()
    {
        $this->assertInstanceOf(Metabox::class, $this->metabox);
    }

    /**
     * @test
     */
    public function testConstructsWithId()
    {
        $this->assertNotEmpty($this->metabox->getId());
    }

    /**
     * @test
     */
    public function testConstructsWithTitle()
    {
        $this->assertNotEmpty($this->metabox->getTitle());
    }

    /**
     * @test
     */
    public function testConstructsWithContext()
    {
        $this->assertNotEmpty($this->metabox->getContext());
    }

    /**
     * @test
     */
    public function testConstructsWithPriority()
    {
        $this->assertNotEmpty($this->metabox->getPriority());
    }

    /**
     * @test
     */
    public function testConstructsWithLayout()
    {
        $this->assertNotEmpty($this->metabox->getLayout());
    }

    /**
     * @test
     */
    public function testIsInstanceOfMetaboxInterface()
    {
        $this->assertInstanceOf(MetaboxInterface::class, $this->metabox);
    }

    /**
     * @test
     */
    public function testCanGetId()
    {
        $expected = 'id';

        $this->assertEquals($expected, $this->metabox->getId());
    }

    /**
     * @test
     */
    public function testCanGetTitle()
    {
        $expected = 'title';

        $this->assertEquals($expected, $this->metabox->getTitle());
    }

    /**
     * @test
     */
    public function testCanSetAndGetScreen()
    {
        $expected = 'post_type';
        $this->metabox->setScreen($expected);

        $this->assertEquals($expected, $this->metabox->getScreen());
    }

    /**
     * @test
     */
    public function testScreenCanBeString()
    {
        $screen = 'screen';
        $this->metabox->setScreen($screen);

        $this->assertIsString($this->metabox->getScreen());
    }

    public function testScreenCanBeArray()
    {
        $screen = ['screen1', 'screen2'];
        $this->metabox->setScreen($screen);

        $this->assertIsArray($this->metabox->getScreen());
    }

    public function testScreenCanBeInstanceOfWpScreen()
    {
        $screen = $this->getMockClass(WP_Screen::class);
        $screen = new WP_Screen();
        $this->metabox->setScreen($screen);

        $this->assertInstanceOf(WP_Screen::class, $this->metabox->getScreen());
    }

    /**
     * @test
     */
    public function testCanSetAndGetContext()
    {
        $context = 'context';
        $metabox = $this->metabox->setContext($context);

        $this->assertEquals($context, $metabox->getContext());
    }

    /**
     * @test
     */
    public function testContextCanBeString()
    {
        $context = 'context';
        $metabox = $this->metabox->setContext($context);

        $this->assertIsString($metabox->getContext());
    }

    /**
     * @test
     */
    public function testCanSetAndGetPriority()
    {
        $expected = 'priority';
        $metabox = $this->metabox->setPriority($expected);

        $this->assertEquals($expected, $metabox->getPriority());
    }

    /**
     * @test
     */
    public function testCanSetAndGetCallbackArgs()
    {
        $expected = ['test_arg' => 'test_value'];
        $metabox = $this->metabox->setCallbackArgs($expected);

        $this->assertEquals($expected, $metabox->getCallbackArgs());
    }

    /**
     * @test
     */
    public function testCanGetLayout()
    {
        $layout = $this->getMockBuilder(MetaboxLayoutInterface::class)
            ->getMock();
        $metabox = new Metabox('id', 'title', $layout);

        $this->assertEquals($layout, $metabox->getLayout());
    }
}
