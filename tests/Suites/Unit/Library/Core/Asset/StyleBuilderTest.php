<?php

declare(strict_types=1);

namespace Tests\Suite\Unit\Library\Core\Asset;

use Leonidas\Contracts\Http\ConstrainerCollectionInterface;
use Leonidas\Library\Core\Asset\Style;
use Leonidas\Library\Core\Asset\StyleBuilder;
use PHPUnit\Framework\TestCase;

class StyleBuilderTest extends TestCase
{
    /**
     * @var StyleBuilder
     */
    protected $styleBuilder;

    protected function setUp(): void
    {
        $this->styleBuilder = new StyleBuilder(
            $this->getConstructedHandle()
        );
    }

    protected function getStyleBuilder(): StyleBuilder
    {
        return $this->styleBuilder;
    }

    protected function getStyleBuilderMinimallyConfiguredForStyleCreation(): StyleBuilder
    {
        $builder = $this->getStyleBuilder();
        $builder->setSrc($this->getProvidedSrc());

        return $builder;
    }

    protected function getConstructedHandle(): string
    {
        return 'test-style';
    }

    protected function getProvidedSrc(): string
    {
        return 'assets/dist/css/style.css';
    }

    protected function getProvidedDependencies(): array
    {
        return ['reset', 'material'];
    }

    protected function getProvidedVersion(): string
    {
        return '3.5.8';
    }

    protected function getProvidedEnqueueFlag(): bool
    {
        return true;
    }

    protected function getProvidedConstrainers(): ConstrainerCollectionInterface
    {
        return $this->getMockBuilder(ConstrainerCollectionInterface::class)->getMock();
    }

    protected function getProvidedAttributes(): array
    {
        return [
            'data-test-1' => 'test-value-1',
            'data-test-2' => 'test-value-2',
        ];
    }

    protected function getProvidedCrossOriginAttribute(): string
    {
        return 'huh?';
    }

    protected function getProvidedMediaAttribute(): string
    {
        return 'print';
    }

    protected function getProvidedDisabledAttribute(): bool
    {
        return true;
    }

    protected function getProvidedHreflangAttribute(): string
    {
        return 'jpn';
    }

    protected function getProvidedTitleAttribute(): string
    {
        return 'title';
    }

    // TESTS

    public function testCanGetConstructedHandle()
    {
        $builder = $this->styleBuilder;

        $this->assertEquals(
            $this->getConstructedHandle(),
            $builder->getHandle()
        );
    }

    public function testCanSetAndGetHandle()
    {
        $builder = $this->styleBuilder;
        $handle = 'post-constructed-handle';

        $builder->setHandle($handle);

        $this->assertNotEquals($handle, $this->getConstructedHandle());
        $this->assertEquals($handle, $builder->getHandle());
    }

    public function testCanSetAndGetSrc()
    {
        $builder = $this->styleBuilder;
        $src = 'assets/js/script.js';

        $builder->setSrc($src);

        $this->assertEquals($src, $builder->getSrc());
    }

    public function testCanSetAndGetDependencies()
    {
        $builder = $this->styleBuilder;
        $dependencies = ['svelte'];

        $builder->setDependencies(...$dependencies);

        $this->assertEquals($dependencies, $builder->getDependencies());
    }

    public function testCanSetAndGetVersion()
    {
        $builder = $this->styleBuilder;
        $version = '4.2.9';

        $builder->setVersion($version);

        $this->assertEquals($version, $builder->getVersion());
    }

    public function testCanSetAndGetConstraints()
    {
        $builder = $this->styleBuilder;
        $constraints = $this->getMockBuilder(ConstrainerCollectionInterface::class)
            ->getMock();

        $builder->setConstraints($constraints);

        $this->assertEquals($constraints, $builder->getConstraints());
    }

    public function testCanSetAndGetAttributes()
    {
        $builder = $this->styleBuilder;
        $attributes = [
            'data-test-1' => 'test-value-1',
            'data-test-2' => 'test-value-2',
        ];

        $builder->setAttributes($attributes);

        $this->assertEquals($attributes, $builder->getAttributes());
    }

    public function testCanSetAndGetCrossorigin()
    {
        $builder = $this->styleBuilder;
        $crossorigin = 'huh.com';

        $builder->setCrossorigin($crossorigin);

        $this->assertEquals($crossorigin, $builder->getCrossorigin());
    }

    public function testCanSetAndGetMedia()
    {
        $builder = $this->styleBuilder;
        $media = 'print';

        $builder->setMedia($media);

        $this->assertEquals($media, $builder->getMedia());
    }

    public function testCanSetAndGetDisabledAttribute()
    {
        $builder = $this->styleBuilder;
        $isDisabled = false;

        $builder->setIsDisabled($isDisabled);

        $this->assertEquals($isDisabled, $builder->isDisabled());
    }

    public function testCanSetAndGetHreflangAttribute()
    {
        $builder = $this->styleBuilder;
        $hrefLang = 'jpn';

        $builder->setHrefLang($hrefLang);

        $this->assertEquals($hrefLang, $builder->getHrefLang());
    }

    public function testCanSetAndGetTitleAttribute()
    {
        $builder = $this->styleBuilder;
        $title = 'title';

        $builder->setTitle($title);

        $this->assertEquals($title, $builder->getTitle());
    }

    /**
     * @test
     */
    public function creates_Style_object_with_only_required_properties_set()
    {
        $style = (new StyleBuilder($this->getConstructedHandle()))
            ->setSrc($this->getProvidedSrc());

        $this->assertInstanceOf(Style::class, $style->build());
    }

    /**
     * @test
     */
    public function setter_methods_return_same_instance_of_StyleBuilder()
    {
        $builder = $this->getStyleBuilder();

        $this->assertEquals($builder, $builder->setHandle($this->getConstructedHandle()));
        $this->assertEquals($builder, $builder->setSrc($this->getProvidedSrc()));
        $this->assertEquals($builder, $builder->setDependencies(...$this->getProvidedDependencies()));
        $this->assertEquals($builder, $builder->setVersion($this->getProvidedVersion()));
        $this->assertEquals($builder, $builder->setShouldBeEnqueued($this->getProvidedEnqueueFlag()));
        $this->assertEquals($builder, $builder->setConstraints($this->getProvidedConstrainers()));
        $this->assertEquals($builder, $builder->setAttributes($this->getProvidedAttributes()));
        $this->assertEquals($builder, $builder->setCrossorigin($this->getProvidedCrossoriginAttribute()));

        $this->assertEquals($builder, $builder->setMedia($this->getProvidedMediaAttribute()));
        $this->assertEquals($builder, $builder->setIsDisabled($this->getProvidedDisabledAttribute()));
        $this->assertEquals($builder, $builder->setHrefLang($this->getProvidedHreflangAttribute()));
        $this->assertEquals($builder, $builder->setTitle($this->getProvidedTitleAttribute()));
    }
}
