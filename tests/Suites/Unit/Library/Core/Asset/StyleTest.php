<?php

declare(strict_types=1);

namespace Tests\Suite\Unit\Library\Core\Asset;

use Leonidas\Contracts\Http\ConstrainerCollectionInterface;
use Leonidas\Contracts\Ui\Asset\StyleInterface;
use Leonidas\Library\Core\Asset\Style;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Message\ServerRequestInterface;
use UnitTester;

class StyleTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var Style
     */
    protected $style;

    protected function setUp(): void
    {
        $this->style = new Style(
            $this->getConstructedHandle(),
            $this->getConstructedSrc(),
            $this->getConstructedDependencies(),
            $this->getConstructedVersion(),
            $this->getConstructedMedia(),
            $this->getConstructedEnqueueFlag(),
            $this->getConstructedConstraints(),
            $this->getConstructedAttributes(),
            $this->getConstructedCrossoriginAttribute(),
            $this->getConstructedDisabledAttribute(),
            $this->getConstructedHrefLangAttribute(),
            $this->getConstructedTitleAttribute()
        );
    }

    protected function tearDown(): void
    {
        //
    }

    protected function getConstructedHandle(): string
    {
        return 'test-handle';
    }

    protected function getConstructedSrc(): string
    {
        return './assets/dist/js/style.css';
    }

    protected function getConstructedDependencies(): array
    {
        return ['bootstrap', 'reset'];
    }

    protected function getConstructedVersion(): string
    {
        return '2.3.5';
    }

    protected function getConstructedEnqueueFlag(): bool
    {
        return true;
    }

    protected function getConstructedConstraints(): ConstrainerCollectionInterface
    {
        return $this->getMockBuilder(ConstrainerCollectionInterface::class)->getMock();
    }

    protected function getConstructedAttributes(): array
    {
        return [
            'data-test' => 'test-attribute',
            'data-test2' => 'test-attribute-2',
        ];
    }

    protected function getConstructedCrossoriginAttribute(): string
    {
        return 'string';
    }

    protected function getConstructedDisabledAttribute(): bool
    {
        return true;
    }

    protected function getConstructedHrefLangAttribute(): string
    {
        return 'es';
    }

    protected function getConstructedTitleAttribute(): string
    {
        return 'what';
    }

    protected function getConstructedMedia(): string
    {
        return 'all';
    }

    // TESTS

    public function testCanGetConstructedHandle()
    {
        $style = $this->style;

        $this->assertEquals(
            $this->getConstructedHandle(),
            $style->getHandle()
        );
    }

    public function testCanGetConstructedSrc()
    {
        $style = $this->style;

        $this->assertEquals(
            $this->getConstructedSrc(),
            $style->getSrc()
        );
    }

    public function testCanGetConstructedDependencies()
    {
        $style = $this->style;

        $this->assertEquals(
            $this->getConstructedDependencies(),
            $style->getDependencies()
        );
    }

    public function testCanGetConstructedVersion()
    {
        $style = $this->style;

        $this->assertEquals(
            $this->getConstructedVersion(),
            $style->getVersion()
        );
    }

    public function testCanGetConstructedMedia()
    {
        $style = $this->style;

        $this->assertEquals(
            $this->getConstructedMedia(),
            $style->getMedia()
        );
    }

    public function testCanGetConstructedEnqueueFlag()
    {
        $style = $this->style;

        $this->assertEquals(
            $this->getConstructedEnqueueFlag(),
            $style->shouldBeEnqueued()
        );
    }

    public function testCanGetConstructedAttributes()
    {
        $style = $this->style;

        $this->assertEquals(
            $this->getConstructedAttributes(),
            $style->getAttributes()
        );
    }

    public function testCanGetConstructedCrossoriginAttribute()
    {
        $style = $this->style;

        $this->assertEquals(
            $this->getConstructedCrossoriginAttribute(),
            $style->getCrossorigin()
        );
    }

    public function testCanGetConstructedDisabledAttribute()
    {
        $style = $this->style;

        $this->assertEquals(
            $this->getConstructedDisabledAttribute(),
            $style->isDisabled()
        );
    }

    public function testCanGetConstructedHrefLangAttribute()
    {
        $style = $this->style;

        $this->assertEquals(
            $this->getConstructedHrefLangAttribute(),
            $style->getHrefLang()
        );
    }

    public function testCanGetConstructedTitleAttribute()
    {
        $style = $this->style;

        $this->assertEquals(
            $this->getConstructedTitleAttribute(),
            $style->getTitle()
        );
    }

    public function test_is_instance_of_StyleInterface()
    {
        $this->assertInstanceOf(StyleInterface::class, $this->style);
    }

    public function test_constructed_constrainer_is_instance_of_ConstrainerCollectionInterface()
    {
        $style = $this->style;

        $this->assertInstanceOf(
            ConstrainerCollectionInterface::class,
            $style->getConstraints()
        );
    }

    public function test_will_not_load_if_intended_to_be_constrained()
    {
        $request = $this->prophesize(ServerRequestInterface::class)->reveal();
        $constraints = $this->prophesize(ConstrainerCollectionInterface::class);
        $constraints->constrains($request)
            ->shouldBeCalled()
            ->willReturn(true);
        $constraints = $constraints->reveal();

        $script = new Style(
            $this->getConstructedHandle(),
            $this->getConstructedSrc(),
            $this->getConstructedDependencies(),
            $this->getConstructedVersion(),
            $this->getConstructedMedia(),
            $this->getConstructedEnqueueFlag(),
            $constraints,
            $this->getConstructedAttributes(),
            $this->getConstructedCrossoriginAttribute(),
            $this->getConstructedDisabledAttribute(),
            $this->getConstructedHrefLangAttribute(),
            $this->getConstructedTitleAttribute()
        );

        $this->assertFalse($script->shouldBeLoaded($request));
    }

    public function test_will_load_if_not_intended_to_be_constrained()
    {
        $request = $this->prophesize(ServerRequestInterface::class)->reveal();
        $constraints = $this->prophesize(ConstrainerCollectionInterface::class);
        $constraints->constrains($request)
            ->shouldBeCalled()
            ->willReturn(false);
        $constraints = $constraints->reveal();

        $script = new Style(
            $this->getConstructedHandle(),
            $this->getConstructedSrc(),
            $this->getConstructedDependencies(),
            $this->getConstructedVersion(),
            $this->getConstructedMedia(),
            $this->getConstructedEnqueueFlag(),
            $constraints,
            $this->getConstructedAttributes(),
            $this->getConstructedCrossoriginAttribute(),
            $this->getConstructedDisabledAttribute(),
            $this->getConstructedHrefLangAttribute(),
            $this->getConstructedTitleAttribute()
        );

        $this->assertTrue($script->shouldBeLoaded($request));
    }
}
