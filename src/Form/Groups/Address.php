<?php

namespace Backalley\Form\Groups;

use Backalley\Form\Contracts\FormSubmissionGroupInterface;
use Backalley\GuctilityBelt\Address\Address as AddressHelper;
use Backalley\GuctilityBelt\Address\AddressGeocoderInterface;

class Address implements FormSubmissionGroupInterface
{
    /**
     *
     */
    protected $fields = [
        'street' => null,
        'city' => null,
        'state' => null,
        'zip' => null,
    ];

    /**
     * @var AddressHelper
     */
    protected $address;

    /**
     * @var AddressGeocoderInterface
     */
    protected $geocoder;

    private const ACCEPTED_FIELDS = ['street', 'city', 'state', 'zip'];

    /**
     *
     */
    public function run($post, $results)
    {
        $updated = false;
        $post_id = $post->ID;

        foreach ($results as $result) {
            if (true === $result['saved']) {
                $updated = true;
                break;
            }
        }

        if (true === $updated) {
            $complete = $this->address->concat(
                $results[$this->fields['street']]['value'],
                $results[$this->fields['city']]['value'],
                $results[$this->fields['state']]['value'],
                $results[$this->fields['zip']]['value']
            );

            update_post_meta($post_id, "ba_location_address__complete", $complete);

            if (isset($this->geocoder)) {

                $coordinates = $this->geocoder->getGeodata($complete);

                update_post_meta($post_id, "ba_location_address__geo", $coordinates);
            }
        }
    }
}
