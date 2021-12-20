<?php

namespace Tests\WpUnit\Library\Core\Asset;

use Leonidas\Contracts\Ui\Asset\ScriptCollectionInterface;
use Leonidas\Contracts\Ui\Asset\ScriptInterface;
use Leonidas\Library\Core\Asset\ScriptLoader;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\WpTest\WpLoadedTestCase;

class ScriptLoaderTest extends WpLoadedTestCase
{
    use ProphecyTrait;

    /**
     * @var ScriptLoader
     */
    protected $loader;

    /**
     * @return ScriptInterface|ScriptInterface[]
     */
    public function getMockScripts(bool $single = false)
    {
        $script1 = $this->prophesize(ScriptInterface::class);
        $script1->shouldBeEnqueued()->willReturn(false);
        $script1->getHandle()->willReturn('test-script-1');
        $script1->getSrc()->willReturn('/assets/js/script-1.js');
        $script1->getDependencies()->willReturn(null);
        $script1->getVersion()->willReturn('2.5.1');
        $script1->shouldLoadInFooter()->willReturn(true);

        $script2 = $this->prophesize(ScriptInterface::class);
        $script2->shouldBeEnqueued()->willReturn(false);
        $script2->getHandle()->willReturn('test-script-2');
        $script2->getSrc()->willReturn('/assets/js/script-1.js');
        $script2->getDependencies()->willReturn(null);
        $script2->getVersion()->willReturn('2.5.1');
        $script2->shouldLoadInFooter()->willReturn(true);

        $scripts = array_map(function (ObjectProphecy $mock): ScriptInterface {
            return $mock->reveal();
        }, [$script1, $script2]);

        return $single ? $scripts[random_int(0, count($scripts) - 1)] : $scripts;
    }

    public function getMockScriptCollection(bool $single = false): ScriptCollectionInterface
    {
        $collection = $this->prophesize(ScriptCollectionInterface::class);
        $collection->getScripts()
            ->willReturn($this->getMockScripts($single));

        return $collection->reveal();
    }

    public function getDummyRequest(): ServerRequestInterface
    {
        return $this->prophesize(ServerRequestInterface::class)->reveal();
    }

    /**
     * @test
     */
    public function it_registers_multiple_scripts()
    {
        $collection = $this->getMockScriptCollection(false);
        $loader = new ScriptLoader($collection);

        $loader->load($this->getDummyRequest());

        foreach ($collection->getScripts() as $script) {
            $this->assertScriptRegistered([
                'handle' => $script->getHandle(),
                'src' => $script->getSrc(),
                'ver' => $script->getVersion(),
                'deps' => $script->getDependencies(),
                'in_footer' => $script->shouldLoadInFooter(),
            ]);
        }
    }

    /**
     * @test
     */
    public function it_renders_html_from_ScriptInterface()
    {
        $this->markTestIncomplete('Need a way to assert html strings match');

        $collection = $this->getMockScriptCollection();
        $scripts = $collection->getScripts();
        $loader = new ScriptLoader($collection);

        $output = $loader::createScriptTag($scripts[0]);
    }
}
