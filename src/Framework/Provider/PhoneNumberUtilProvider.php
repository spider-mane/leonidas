<?php

namespace Leonidas\Framework\Provider;

use libphonenumber\MetadataLoaderInterface;
use libphonenumber\MetadataSourceInterface;
use libphonenumber\PhoneNumberUtil;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;

class PhoneNumberUtilProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): PhoneNumberUtil
    {
        $metadataLoader = $this->getNullable(
            MetadataLoaderInterface::class,
            $container,
        );

        $metadataSource = $this->getNullable(
            MetadataSourceInterface::class,
            $container,
        );

        return PhoneNumberUtil::getInstance(
            $args['base_file_location'] ?? PhoneNumberUtil::META_DATA_FILE_PREFIX,
            $args['country_calling_code_to_region_code_map'] ?? null,
            $metadataLoader,
            $metadataSource
        );
    }
}
