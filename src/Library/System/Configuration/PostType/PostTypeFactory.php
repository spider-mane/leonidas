<?php

namespace Leonidas\Library\System\Configuration\PostType;

use Jawira\CaseConverter\CaseConverter;
use Leonidas\Contracts\System\Configuration\PostType\PostTypeBuilderInterface;
use Leonidas\Contracts\System\Configuration\PostType\PostTypeFactoryInterface;
use Leonidas\Library\System\Configuration\Abstracts\AbstractModelConfigurationFactory;

class PostTypeFactory extends AbstractModelConfigurationFactory implements PostTypeFactoryInterface
{
    public function create(string $name, array $args): PostType
    {
        return $this->build($name, $args)->get();
    }

    public function createMany(array $definitions): array
    {
        return array_map(
            fn (PostTypeBuilderInterface $builder) => $builder->get(),
            $this->buildMany($definitions),
        );
    }

    public function build(string $name, array $args): PostTypeBuilder
    {
        $builder = new PostTypeBuilder($this->prefix($name));
        $converter = new CaseConverter();

        foreach ($this->parseArgs($args) as $arg => $val) {
            $method = $converter->convert($arg)->toCamel();

            if (method_exists($builder, $method)) {
                ([$builder, $method])($val);
            }
        }

        return $builder;
    }

    public function buildMany(array $definitions): array
    {
        $postTypes = [];

        foreach ($definitions as $name => $args) {
            $postTypes[] = $this->build($name, $args);
        }

        return $postTypes;
    }
}
