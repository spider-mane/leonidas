<?php

namespace WebTheory\GuctilityBelt\Address;

interface AddressGeocoderInterface
{
    /**
     *
     */
    public function getGeodata(string $address);
}
