<?php

namespace Tests\Admin\Metabox;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use WebTheory\Leonidas\Admin\Contracts\MetaboxLayoutInterface;
use WebTheory\Leonidas\Admin\Enum\MetaboxContext;
use WebTheory\Leonidas\Admin\Enum\MetaboxPriority;
use WebTheory\Leonidas\Admin\Metabox\Metabox;

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
    public function can_get_id()
    {
        $expected = 'id';
        $actual = $this->metabox->getId();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function can_get_title()
    {
        $expected = 'title';
        $actual = $this->metabox->getTitle();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function can_set_and_get_screen()
    {
        $expected = 'post_type';
        $actual = $this->metabox->getScreen();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function can_set_and_get_context()
    {
        $context = $this->getMockBuilder(MetaboxContext::class)
            ->getMock();

        $metabox = $this->metabox->setContext($context);

        $this->assertEquals($context, $metabox->getContext());
    }

    /**
     * @test
     */
    public function context_can_be_instance_of_MetaboxContext()
    {
        $context = $this->getMockBuilder(MetaboxContext::class)
            ->getMock();

        $metabox = $this->metabox->setContext($context);

        $this->assertInstanceOf(MetaboxContext::class, $metabox->getContext());
    }

    /**
     * @test
     */
    public function context_can_be_null()
    {
        $metabox = $this->metabox->setContext(null);

        $this->assertNull($metabox->getContext());
    }

    /**
     * @test
     */
    public function can_set_and_get_priority()
    {
        $expected = new MetaboxPriority('low');
        $metabox = $this->metabox->setPriority($expected);

        $this->assertEquals($expected, $metabox->getPriority());
    }

    /**
     * @test
     */
    public function can_set_and_get_callback_args()
    {
        $expected = ['test_arg' => 'test_value'];

        $metabox = $this->metabox->setCallbackArgs($expected);

        $this->assertEquals($expected, $metabox->getCallbackArgs());
    }

    /**
     * @test
     */
    public function can_get_layout()
    {
        $layout = $this->getMockBuilder(MetaboxLayoutInterface::class)
            ->getMock();

        $metabox = new Metabox('id', 'title', $layout);

        $this->assertEquals($layout, $metabox->getLayout());
    }
}
