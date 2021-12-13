<?php

declare(strict_types=1);

namespace Tests\Suite\Unit\Library\Core\Asset;

use Leonidas\Contracts\Http\ConstrainerCollectionInterface;
use Leonidas\Library\Core\Asset\Script;
use Leonidas\Library\Core\Asset\ScriptBuilder;
use PHPUnit\Framework\TestCase;

class ScriptBuilderTest extends TestCase
{
    /**
     * @var ScriptBuilder
     */
    protected $scriptBuilder;

    protected function setUp(): void
    {
        $this->scriptBuilder = new ScriptBuilder(
            $this->getConstructedHandle()
        );
    }

    protected function getScriptBuilder(): ScriptBuilder
    {
        return $this->scriptBuilder;
    }

    protected function getScriptBuilderMinimallyConfiguredForScriptCreation(): ScriptBuilder
    {
        $builder = $this->getScriptBuilder();
        $builder->setSrc($this->getProvidedSrc());

        return $builder;
    }

    protected function getConstructedHandle(): string
    {
        return 'test-script';
    }

    protected function getProvidedSrc(): string
    {
        return 'assets/dist/js/style.css';
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

    protected function getProvidedLoadInFooterFlag(): bool
    {
        return false;
    }

    protected function getProvidedAttributes(): array
    {
        return [
            'data-test-1' => 'test-value-1',
            'data-test-2' => 'test-value-2',
        ];
    }

    protected function getProvidedCrossoriginAttribute(): string
    {
        return 'huh?';
    }

    protected function getProvidedAsyncAttribute(): bool
    {
        return false;
    }

    protected function getProvidedDeferredAttribute(): bool
    {
        return false;
    }

    protected function getProvidedIntegrityAttribute(): string
    {
        return '';
    }

    protected function getProvidedNomoduleAttribute(): bool
    {
        return true;
    }

    protected function getProvidedNonceAttribute(): string
    {
        return '';
    }

    protected function getProvidedReferrerpolicyAttribute(): string
    {
        return '';
    }

    protected function getProvidedTypeAttribute(): string
    {
        return '';
    }

    // TESTS

    /**
     * @test
     */
    public function it_can_get_constructed_handle()
    {
        $builder = $this->scriptBuilder;

        $this->assertEquals(
            $this->getConstructedHandle(),
            $builder->getHandle()
        );
    }

    /**
     * @test
     */
    public function it_can_get_and_set_handle()
    {
        $builder = $this->scriptBuilder;
        $handle = 'post-constructed-handle';

        $builder->setHandle($handle);

        $this->assertNotEquals($handle, $this->getConstructedHandle());
        $this->assertEquals($handle, $builder->getHandle());
    }

    /**
     * @test
     */
    public function it_can_get_and_set_src()
    {
        $builder = $this->scriptBuilder;
        $src = 'assets/js/script.js';

        $builder->setSrc($src);

        $this->assertEquals($src, $builder->getSrc());
    }

    /**
     * @test
     */
    public function it_can_get_and_set_dependencies()
    {
        $builder = $this->scriptBuilder;
        $dependencies = ['svelte'];

        $builder->setDependencies(...$dependencies);

        $this->assertEquals($dependencies, $builder->getDependencies());
    }

    /**
     * @test
     */
    public function it_can_get_and_set_version()
    {
        $builder = $this->scriptBuilder;
        $version = '4.2.9';

        $builder->setVersion($version);

        $this->assertEquals($version, $builder->getVersion());
    }

    /**
     * @test
     */
    public function it_can_get_and_set_enqueue_flag()
    {
        $builder = $this->scriptBuilder;
        $shouldBeEnqueued = true;

        $builder->setShouldBeEnqueued($shouldBeEnqueued);

        $this->assertEquals($shouldBeEnqueued, $builder->shouldBeEnqueued());
    }

    /**
     * @test
     */
    public function it_can_get_and_set_constraints()
    {
        $builder = $this->scriptBuilder;
        $constraints = $this->getMockBuilder(ConstrainerCollectionInterface::class)
            ->getMock();

        $builder->setConstraints($constraints);

        $this->assertEquals($constraints, $builder->getConstraints());
    }

    /**
     * @test
     */
    public function it_can_set_and_get_attributes()
    {
        $builder = $this->scriptBuilder;
        $attributes = [
            'data-test-1' => 'test-value-1',
            'data-test-2' => 'test-value-2',
        ];

        $builder->setAttributes($attributes);

        $this->assertEquals($attributes, $builder->getAttributes());
    }

    /**
     * @test
     */
    public function it_can_set_and_get_crossorigin_attribute()
    {
        $builder = $this->scriptBuilder;
        $crossorigin = 'huh.com';

        $builder->setCrossorigin($crossorigin);

        $this->assertEquals($crossorigin, $builder->getCrossorigin());
    }

    /**
     * @test
     */
    public function it_can_get_and_set_footer_flag()
    {
        $builder = $this->scriptBuilder;
        $shouldLoadInFooter = true;

        $builder->setShouldLoadInFooter($shouldLoadInFooter);

        $this->assertEquals($shouldLoadInFooter, $builder->shouldLoadInFooter());
    }

    /**
     * @test
     */
    public function it_can_set_and_get_async_attribute()
    {
        $builder = $this->scriptBuilder;
        $isAsync = false;

        $builder->setIsAsync($isAsync);

        $this->assertEquals($isAsync, $builder->isAsync());
    }

    /**
     * @test
     */
    public function it_can_set_and_get_deferred_attribute()
    {
        $builder = $this->scriptBuilder;
        $isDeferred = false;

        $builder->setIsDeferred($isDeferred);

        $this->assertEquals($isDeferred, $builder->isDeferred());
    }

    /**
     * @test
     */
    public function it_can_set_and_get_integrity_attribute()
    {
        $builder = $this->scriptBuilder;
        $integrity = 'what?';

        $builder->setIntegrity($integrity);

        $this->assertEquals($integrity, $builder->getIntegrity());
    }

    /**
     * @test
     */
    public function it_can_set_and_get_nomodule_attribute()
    {
        $builder = $this->scriptBuilder;
        $isNoModule = false;

        $builder->setIsNoModule($isNoModule);

        $this->assertEquals($isNoModule, $builder->isNoModule());
    }

    /**
     * @test
     */
    public function it_can_set_and_get_nonce_attribute()
    {
        $builder = $this->scriptBuilder;
        $nonce = 'fgasgfafhslgahfla';

        $builder->setNonce($nonce);

        $this->assertEquals($nonce, $builder->getNonce());
    }

    /**
     * @test
     */
    public function can_set_and_get_referrerpolicy_attribute()
    {
        $builder = $this->scriptBuilder;
        $refererPolicy = '';

        $builder->setReferrerPolicy($refererPolicy);

        $this->assertEquals($refererPolicy, $builder->getReferrerPolicy());
    }

    /**
     * @test
     */
    public function it_can_set_and_get_type_attribute()
    {
        $builder = $this->scriptBuilder;
        $type = '';

        $builder->setType($type);

        $this->assertEquals($type, $builder->getType());
    }

    /**
     * @test
     */
    public function creates_Script_object_with_only_required_properties_set()
    {
        $builder = (new ScriptBuilder($this->getConstructedHandle()))
            ->setSrc($this->getProvidedSrc());

        $this->assertInstanceOf(Script::class, $builder->build());
    }

    /**
     * @test
     */
    public function setter_methods_return_same_instance()
    {
        $builder = $this->getScriptBuilder();

        $this->assertEquals($builder, $builder->setHandle($this->getConstructedHandle()));
        $this->assertEquals($builder, $builder->setSrc($this->getProvidedSrc()));
        $this->assertEquals($builder, $builder->setDependencies(...$this->getProvidedDependencies()));
        $this->assertEquals($builder, $builder->setVersion($this->getProvidedVersion()));
        $this->assertEquals($builder, $builder->setShouldBeEnqueued($this->getProvidedEnqueueFlag()));
        $this->assertEquals($builder, $builder->setConstraints($this->getProvidedConstrainers()));
        $this->assertEquals($builder, $builder->setAttributes($this->getProvidedAttributes()));
        $this->assertEquals($builder, $builder->setCrossorigin($this->getProvidedCrossoriginAttribute()));
        $this->assertEquals($builder, $builder->setShouldLoadInFooter($this->getProvidedLoadInFooterFlag()));
        $this->assertEquals($builder, $builder->setIsAsync($this->getProvidedAsyncAttribute()));
        $this->assertEquals($builder, $builder->setIsDeferred($this->getProvidedDeferredAttribute()));
        $this->assertEquals($builder, $builder->setIntegrity($this->getProvidedIntegrityAttribute()));
        $this->assertEquals($builder, $builder->setIsNoModule($this->getProvidedNomoduleAttribute()));
        $this->assertEquals($builder, $builder->setNonce($this->getProvidedNonceAttribute()));
        $this->assertEquals($builder, $builder->setReferrerPolicy($this->getProvidedReferrerpolicyAttribute()));
        $this->assertEquals($builder, $builder->setType($this->getProvidedTypeAttribute()));
    }
}
