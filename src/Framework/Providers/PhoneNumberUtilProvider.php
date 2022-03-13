<?php

namespace Leonidas\Framework\Providers;

use libphonenumber\MetadataSourceInterface;
use libphonenumber\PhoneNumberUtil;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;

class PhoneNumberUtilProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): PhoneNumberUtil
    {
        $metadataLoader = $container->has(MetadataLoaderInterface::class)
            ? $container->get(MetadataLoaderInterface::class)
            : null;

        $metadataSource = $container->has(MetadataSourceInterface::class)
            ? $container->get(MetadataSourceInterface::class)
            : null;

        return PhoneNumberUtil::getInstance(
            $args['base_file_location'] ?? PhoneNumberUtil::META_DATA_FILE_PREFIX,
            $args['country_calling_code_to_region_code_map'] ?? null,
            $metadataLoader,
            $metadataSource
        );
    }
}
