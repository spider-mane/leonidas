<?php

namespace WebTheory\GuctilityBelt\Address;

class Address
{
    /**
     * @var AddressGeocoderInterface
     */
    protected $geocoder;

    /**
     * Get the value of geocoder
     *
     * @return AddressGeocoderInterface
     */
    public function getGeocoder(): AddressGeocoderInterface
    {
        return $this->geocoder;
    }

    /**
     * Set the value of geocoder
     *
     * @param AddressGeocoderInterface $geocoder
     *
     * @return self
     */
    public function setGeocoder(AddressGeocoderInterface $geocoder)
    {
        $this->geocoder = $geocoder;

        return $this;
    }

    /**
     *
     */
    public function concat(string $street, string $city, string $state, string $zip)
    {
        return "${street}, ${city}, ${state} ${zip}";
    }

    /**
     *
     */
    public function getGeodata(string $address)
    {
        if (!isset($this->geocoder)) {
            throw new \Exception(static::class . 'must have instance of ' . AddressGeocoderInterface::class . ' to use this functionality');
        }

        return $this->geocoder->getGeodata($address);
    }
}
