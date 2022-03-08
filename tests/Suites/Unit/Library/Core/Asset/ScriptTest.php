<?php

declare(strict_types=1);

namespace Tests\Suites\Unit\Library\Core\Asset;

use Leonidas\Contracts\Http\ServerRequestPolicyInterface;
use Leonidas\Contracts\Ui\Asset\ScriptInterface;
use Leonidas\Library\Core\Asset\Script;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Message\ServerRequestInterface;
use UnitTester;

class ScriptTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var Script
     */
    protected $script;

    protected function setUp(): void
    {
        $this->script = new Script(
            $this->getConstructedHandle(),
            $this->getConstructedSrc(),
            $this->getConstructedDependencies(),
            $this->getConstructedVersion(),
            $this->getConstructedFooterFlag(),
            $this->getConstructedEnqueueFlag(),
            $this->getConstructedConstraints(),
            $this->getConstructedAttributes(),
            $this->getConstructedAsyncAttribute(),
            $this->getConstructedCrossoriginAttribute(),
            $this->getConstructedDeferredAttribute(),
            $this->getConstructedIntegrityAttribute(),
            $this->getConstructedNoModuleAttribute(),
            $this->getConstructedNonceAttribute(),
            $this->getConstructedReferrerPolicyAttribute(),
            $this->getConstructedTypeAttribute()
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
        return './assets/dist/js/script.js';
    }

    protected function getConstructedDependencies(): array
    {
        return ['jquery', 'react'];
    }

    protected function getConstructedVersion(): string
    {
        return '2.3.4';
    }

    protected function getConstructedFooterFlag(): bool
    {
        return true;
    }

    protected function getConstructedEnqueueFlag(): bool
    {
        return true;
    }

    protected function getConstructedConstraints(): ServerRequestPolicyInterface
    {
        return $this->prophesize(ServerRequestPolicyInterface::class)->reveal();
    }

    protected function getConstructedAttributes(): array
    {
        return [
            'data-test' => 'test-attribute',
            'data-test2' => 'test-attribute-2',
        ];
    }

    protected function getConstructedAsyncAttribute(): bool
    {
        return true;
    }

    protected function getConstructedCrossoriginAttribute(): string
    {
        return '';
    }

    protected function getConstructedDeferredAttribute(): bool
    {
        return true;
    }

    protected function getConstructedIntegrityAttribute(): string
    {
        return '';
    }

    protected function getConstructedNoModuleAttribute(): bool
    {
        return true;
    }

    protected function getConstructedNonceAttribute(): string
    {
        return '';
    }

    protected function getConstructedReferrerPolicyAttribute(): string
    {
        return '';
    }

    protected function getConstructedTypeAttribute(): string
    {
        return '';
    }

    // TESTS

    public function testCanGetConstructedHandle()
    {
        $script = $this->script;

        $this->assertEquals(
            $this->getConstructedHandle(),
            $script->getHandle()
        );
    }

    public function testCanGetConstructedSrc()
    {
        $script = $this->script;

        $this->assertEquals(
            $this->getConstructedSrc(),
            $script->getSrc()
        );
    }

    public function testCanGetConstructedDependencies()
    {
        $script = $this->script;

        $this->assertEquals(
            $this->getConstructedDependencies(),
            $script->getDependencies()
        );
    }

    public function testCanGetConstructedVersion()
    {
        $script = $this->script;

        $this->assertEquals(
            $this->getConstructedVersion(),
            $script->getVersion()
        );
    }

    public function testCanGetConstructedFooterFlag()
    {
        $script = $this->script;

        $this->assertEquals(
            $this->getConstructedFooterFlag(),
            $script->shouldLoadInFooter()
        );
    }

    public function testCanGetConstructedEnqueueFlag()
    {
        $script = $this->script;

        $this->assertEquals(
            $this->getConstructedEnqueueFlag(),
            $script->shouldBeEnqueued()
        );
    }

    public function testCanGetConstructedAttributes()
    {
        $script = $this->script;

        $this->assertEquals(
            $this->getConstructedAttributes(),
            $script->getAttributes()
        );
    }

    public function testCanGetConstructedAsyncAttribute()
    {
        $script = $this->script;

        $this->assertEquals(
            $this->getConstructedAsyncAttribute(),
            $script->isAsync()
        );
    }

    public function testCanGetConstructedCrossoriginAttribute()
    {
        $script = $this->script;

        $this->assertEquals(
            $this->getConstructedCrossoriginAttribute(),
            $script->getCrossorigin()
        );
    }

    public function testCanGetConstructedDeferredAttribute()
    {
        $script = $this->script;

        $this->assertEquals(
            $this->getConstructedDeferredAttribute(),
            $script->isDeferred()
        );
    }

    public function testCanGetConstructedIntegrityAttribute()
    {
        $script = $this->script;

        $this->assertEquals(
            $this->getConstructedIntegrityAttribute(),
            $script->getIntegrity()
        );
    }

    public function testCanGetConstructedNoModuleAttribute()
    {
        $script = $this->script;

        $this->assertEquals(
            $this->getConstructedNoModuleAttribute(),
            $script->isNoModule()
        );
    }

    public function testCanGetConstructedNonceAttribute()
    {
        $script = $this->script;

        $this->assertEquals(
            $this->getConstructedNonceAttribute(),
            $script->getNonce()
        );
    }

    public function testCanGetConstructedReferrerPolicyAttribute()
    {
        $script = $this->script;

        $this->assertEquals(
            $this->getConstructedReferrerPolicyAttribute(),
            $script->getReferrerPolicy()
        );
    }

    public function testCanGetConstructedTypeAttribute()
    {
        $script = $this->script;

        $this->assertEquals(
            $this->getConstructedTypeAttribute(),
            $script->getType()
        );
    }

    public function test_is_instance_of_ScriptInterface()
    {
        $this->assertInstanceOf(ScriptInterface::class, $this->script);
    }

    public function test_constructed_policy_is_instance_of_ConstrainerCollectionInterface()
    {
        $script = $this->script;

        $this->assertInstanceOf(
            ServerRequestPolicyInterface::class,
            $script->getConstraints()
        );
    }

    public function test_will_not_load_if_intended_to_be_constrained()
    {
        $request = $this->prophesize(ServerRequestInterface::class)->reveal();
        $policy = $this->prophesize(ServerRequestPolicyInterface::class);
        $policy->constrains($request)
            ->shouldBeCalled()
            ->willReturn(true);
        $policy = $policy->reveal();

        $script = new Script(
            $this->getConstructedHandle(),
            $this->getConstructedSrc(),
            $this->getConstructedDependencies(),
            $this->getConstructedVersion(),
            $this->getConstructedFooterFlag(),
            $this->getConstructedEnqueueFlag(),
            $policy,
            $this->getConstructedAttributes(),
            $this->getConstructedAsyncAttribute(),
            $this->getConstructedCrossoriginAttribute(),
            $this->getConstructedDeferredAttribute(),
            $this->getConstructedIntegrityAttribute(),
            $this->getConstructedNoModuleAttribute(),
            $this->getConstructedNonceAttribute(),
            $this->getConstructedReferrerPolicyAttribute(),
            $this->getConstructedTypeAttribute()
        );

        $this->assertFalse($script->shouldBeLoaded($request));
    }

    public function test_will_load_if_not_intended_to_be_constrained()
    {
        $request = $this->prophesize(ServerRequestInterface::class)->reveal();
        $policy = $this->prophesize(ServerRequestPolicyInterface::class);
        $policy->constrains($request)
            ->shouldBeCalled()
            ->willReturn(false);
        $policy = $policy->reveal();

        $script = new Script(
            $this->getConstructedHandle(),
            $this->getConstructedSrc(),
            $this->getConstructedDependencies(),
            $this->getConstructedVersion(),
            $this->getConstructedFooterFlag(),
            $this->getConstructedEnqueueFlag(),
            $policy,
            $this->getConstructedAttributes(),
            $this->getConstructedAsyncAttribute(),
            $this->getConstructedCrossoriginAttribute(),
            $this->getConstructedDeferredAttribute(),
            $this->getConstructedIntegrityAttribute(),
            $this->getConstructedNoModuleAttribute(),
            $this->getConstructedNonceAttribute(),
            $this->getConstructedReferrerPolicyAttribute(),
            $this->getConstructedTypeAttribute()
        );

        $this->assertTrue($script->shouldBeLoaded($request));
    }
}
