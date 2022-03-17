<?php

namespace Leonidas\Library\System\Model\Taxonomy;

use Jawira\CaseConverter\CaseConverter;
use Leonidas\Contracts\System\Model\Taxonomy\TaxonomyFactoryInterface;
use Leonidas\Library\System\Model\AbstractSystemModelTypeFactory;

class TaxonomyFactory extends AbstractSystemModelTypeFactory implements TaxonomyFactoryInterface
{
    public function create(string $name, array $args): Taxonomy
    {
        return $this->build($name, $args)->get();
    }

    public function createMany(array $definitions): array
    {
        return array_map(
            fn (TaxonomyBuilder $builder) => $builder->get(),
            $this->buildMany($definitions),
        );
    }

    public function build(string $name, array $args): TaxonomyBuilder
    {
        $builder = new TaxonomyBuilder();
        $converter = new CaseConverter();

        $builder->name($this->prefix($name));
        $builder->objectTypes(...$args['object_types']);

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

    protected function parseArgs($args): array
    {
        unset($args['object_types']);

        return parent::parseArgs($args);
    }
}
