<?php

declare(strict_types=1);

namespace Tests\Suites\Unit\Library\Core\Asset;

use Leonidas\Contracts\Http\ServerRequestPolicyInterface;
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
        $builder->src($this->getProvidedSrc());

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

    protected function getProvidedPolicies(): ServerRequestPolicyInterface
    {
        return $this->getMockBuilder(ServerRequestPolicyInterface::class)->getMock();
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

        $builder->handle($handle);

        $this->assertNotEquals($handle, $this->getConstructedHandle());
        $this->assertEquals($handle, $builder->getHandle());
    }

    public function testCanSetAndGetSrc()
    {
        $builder = $this->styleBuilder;
        $src = 'assets/js/script.js';

        $builder->src($src);

        $this->assertEquals($src, $builder->getSrc());
    }

    public function testCanSetAndGetDependencies()
    {
        $builder = $this->styleBuilder;
        $dependencies = ['svelte'];

        $builder->dependencies(...$dependencies);

        $this->assertEquals($dependencies, $builder->getDependencies());
    }

    public function testCanSetAndGetVersion()
    {
        $builder = $this->styleBuilder;
        $version = '4.2.9';

        $builder->version($version);

        $this->assertEquals($version, $builder->getVersion());
    }

    public function testCanSetAndGetConstraints()
    {
        $builder = $this->styleBuilder;
        $policy = $this->getMockBuilder(ServerRequestPolicyInterface::class)
            ->getMock();

        $builder->policy($policy);

        $this->assertEquals($policy, $builder->getConstraints());
    }

    public function testCanSetAndGetAttributes()
    {
        $builder = $this->styleBuilder;
        $attributes = [
            'data-test-1' => 'test-value-1',
            'data-test-2' => 'test-value-2',
        ];

        $builder->attributes($attributes);

        $this->assertEquals($attributes, $builder->getAttributes());
    }

    public function testCanSetAndGetCrossorigin()
    {
        $builder = $this->styleBuilder;
        $crossorigin = 'huh.com';

        $builder->crossorigin($crossorigin);

        $this->assertEquals($crossorigin, $builder->getCrossorigin());
    }

    public function testCanSetAndGetMedia()
    {
        $builder = $this->styleBuilder;
        $media = 'print';

        $builder->media($media);

        $this->assertEquals($media, $builder->getMedia());
    }

    public function testCanSetAndGetDisabledAttribute()
    {
        $builder = $this->styleBuilder;
        $isDisabled = false;

        $builder->disabled($isDisabled);

        $this->assertEquals($isDisabled, $builder->isDisabled());
    }

    public function testCanSetAndGetHreflangAttribute()
    {
        $builder = $this->styleBuilder;
        $hrefLang = 'jpn';

        $builder->hreflang($hrefLang);

        $this->assertEquals($hrefLang, $builder->getHrefLang());
    }

    public function testCanSetAndGetTitleAttribute()
    {
        $builder = $this->styleBuilder;
        $title = 'title';

        $builder->title($title);

        $this->assertEquals($title, $builder->getTitle());
    }

    /**
     * @test
     */
    public function creates_Style_object_with_only_required_properties_set()
    {
        $style = (new StyleBuilder($this->getConstructedHandle()))
            ->src($this->getProvidedSrc());

        $this->assertInstanceOf(Style::class, $style->build());
    }

    /**
     * @test
     */
    public function setter_methods_return_same_instance_of_StyleBuilder()
    {
        $builder = $this->getStyleBuilder();

        $this->assertEquals($builder, $builder->handle($this->getConstructedHandle()));
        $this->assertEquals($builder, $builder->src($this->getProvidedSrc()));
        $this->assertEquals($builder, $builder->dependencies(...$this->getProvidedDependencies()));
        $this->assertEquals($builder, $builder->version($this->getProvidedVersion()));
        $this->assertEquals($builder, $builder->enqueue($this->getProvidedEnqueueFlag()));
        $this->assertEquals($builder, $builder->policy($this->getProvidedPolicies()));
        $this->assertEquals($builder, $builder->attributes($this->getProvidedAttributes()));
        $this->assertEquals($builder, $builder->crossorigin($this->getProvidedCrossoriginAttribute()));

        $this->assertEquals($builder, $builder->media($this->getProvidedMediaAttribute()));
        $this->assertEquals($builder, $builder->disabled($this->getProvidedDisabledAttribute()));
        $this->assertEquals($builder, $builder->hreflang($this->getProvidedHreflangAttribute()));
        $this->assertEquals($builder, $builder->title($this->getProvidedTitleAttribute()));
    }
}
