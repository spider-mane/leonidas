<?php

namespace WebTheory\GuctilityBelt\Address;

class GoogleGeocoder implements AddressGeocoderInterface
{
    /**
     *
     */
    protected $apiKey;

    /**
     *
     */
    protected const URI = "https://maps.googleapis.com/maps/api/geocode/json?address=%s&key=%s";

    /**
     *
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     *
     */
    public function getGeodata(string $address)
    {
        $address = urlencode($address);

        $url = sprintf($this::URI, $address, $this->apiKey);

        $response = json_decode(file_get_contents($url), true);

        if ('OK' === $response['status']) {
            $coordinates = $response['results'][0]['geometry']['location'];

            return json_encode($coordinates);
        }
    }
}
