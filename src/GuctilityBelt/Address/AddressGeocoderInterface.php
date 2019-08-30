<?php

namespace Backalley\GuctilityBelt\Address;

interface AddressGeocoderInterface
{
    /**
     *
     */
    public function getGeodata(string $address);
}
