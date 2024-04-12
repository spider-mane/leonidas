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
        $util = $this->getUtilProxy();

        return $util::getInstance(
            $args['base_file_location'] ?? null,
            $args['country_calling_code_to_region_code_map'] ?? null,
            $this->fetch(MetadataLoaderInterface::class, $container),
            $this->fetch(MetadataSourceInterface::class, $container)
        );
    }

    protected function getUtilProxy(): PhoneNumberUtil
    {
        return new class () extends PhoneNumberUtil {
            public function __construct(
                ?MetadataSourceInterface $metadataSource = null,
                $countryCallingCodeToRegionCodeMap = null
            ) {
                if ($metadataSource) {
                    parent::__construct(
                        $metadataSource,
                        $countryCallingCodeToRegionCodeMap
                    );
                }
            }
        };
    }
}
