<?php

namespace Leonidas\Library\System\Configuration\Taxonomy;

use Jawira\CaseConverter\CaseConverter;
use Leonidas\Contracts\System\Configuration\Taxonomy\TaxonomyBuilderInterface;
use Leonidas\Contracts\System\Configuration\Taxonomy\TaxonomyFactoryInterface;
use Leonidas\Library\System\Configuration\Abstracts\AbstractModelConfigurationFactory;

class TaxonomyFactory extends AbstractModelConfigurationFactory implements TaxonomyFactoryInterface
{
    public function create(string $name, array $args): Taxonomy
    {
        return $this->build($name, $args)->get();
    }

    public function createMany(array $definitions): array
    {
        return array_map(
            fn (TaxonomyBuilderInterface $builder) => $builder->get(),
            $this->buildMany($definitions),
        );
    }

    public function build(string $name, array $args): TaxonomyBuilder
    {
        $builder = new TaxonomyBuilder($this->prefix($name));
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

    protected function parseArgs($args): array
    {
        unset($args['object_types']);

        return parent::parseArgs($args);
    }
}
