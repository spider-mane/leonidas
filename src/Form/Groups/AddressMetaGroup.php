<?php

namespace WebTheory\Saveyour\Groups;

use WebTheory\Saveyour\Contracts\FieldDataManagerInterface;
use WebTheory\Saveyour\Contracts\FormFieldControllerInterface;
use WebTheory\Saveyour\Contracts\FormSubmissionGroupInterface;
use WebTheory\GuctilityBelt\Address\Address as AddressHelper;
use WebTheory\GuctilityBelt\Address\AddressGeocoderInterface;

class AddressMetaGroup implements FormSubmissionGroupInterface
{
    /**
     * @var array
     */
    protected $fields = [
        'street' => null,
        'city' => null,
        'state' => null,
        'zip' => null,
    ];

    /**
     * @var FieldDataManagerInterface
     */
    protected $addressDataManager;

    /**
     * @var FieldDataManagerInterface
     */
    protected $geoDataManager;

    /**
     * @var AddressHelper
     */
    protected $addressHelper;

    /**
     * @var AddressGeocoderInterface
     */
    protected $geocoder;

    private const ACCEPTED_FIELDS = ['street', 'city', 'state', 'zip'];

    /**
     *
     */
    public function __construct(AddressHelper $addressHelper, FieldDataManagerInterface $addressDataManager)
    {
        $this->addressHelper = $addressHelper;
        $this->addressDataManager = $addressDataManager;
    }

    /**
     * Get the value of fields
     *
     * @return mixed
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * Get the value of addressDataManager
     *
     * @return FieldDataManagerInterface
     */
    public function getAddressDataManager(): FieldDataManagerInterface
    {
        return $this->addressDataManager;
    }

    /**
     * Get the value of addressHelper
     *
     * @return AddressHelper
     */
    public function getAddressHelper(): AddressHelper
    {
        return $this->addressHelper;
    }

    /**
     * Get the value of geoDataManager
     *
     * @return FieldDataManagerInterface
     */
    public function getGeoDataManager(): FieldDataManagerInterface
    {
        return $this->geoDataManager;
    }

    /**
     * Set the value of geoDataManager
     *
     * @param FieldDataManagerInterface $geoDataManager
     *
     * @return self
     */
    public function setGeoDataManager(FieldDataManagerInterface $geoDataManager)
    {
        $this->geoDataManager = $geoDataManager;

        return $this;
    }

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
    public function setField(string $field, FormFieldControllerInterface $controller)
    {
        if (!in_array($field, $this::ACCEPTED_FIELDS, true)) {
            throw new \InvalidArgumentException("{$field} is not an accepted value");
        }

        $this->fields[$field] = $controller;
    }

    /**
     *
     */
    public function run($request, $results)
    {
        if ($this->valueUpdated($results)) {
            $this->processData($request, $results);
        }
    }

    /**
     *
     */
    protected function valueUpdated($results): bool
    {
        $updated = false;

        foreach ($results as $result) {
            if (true === $result['saved']) {
                $updated = true;
                break;
            }
        }

        return $updated;
    }

    /**
     * @param array $fields individual components that compose the address
     */
    protected function formatAddress(array $fields)
    {
        return $this->addressHelper->concat(
            $fields['street'],
            $fields['city'],
            $fields['state'],
            $fields['zip']
        );
    }

    /**
     *
     */
    protected function processData($request, $results)
    {
        $geocoder = $this->addressHelper->getGeocoder() ?? $this->geocoder ?? null;
        $fields = [];

        /** @var FormFieldControllerInterface $controller */
        foreach ($this->fields as $field => $controller) {
            $fields[$field] = $results[$controller->getFormFieldName()]['value'];
        }

        $formattedAddress = $this->formatAddress($fields);

        $this->addressDataManager->handleSubmittedData($request, $formattedAddress);

        if (isset($this->geoDataManager) && isset($geocoder)) {
            $this->geoDataManager->handleSubmittedData($request, $geocoder->getGeodata($formattedAddress));
        }
    }
}
