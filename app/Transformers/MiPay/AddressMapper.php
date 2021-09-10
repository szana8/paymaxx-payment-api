<?php

namespace App\Transformers\MiPay;

class AddressMapper
{
    /**
     * @var string
     */
    private $addr1;
    /**
     * @var string
     */
    private $town;
    /**
     * @var string
     */
    private $postcode;
    /**
     * @var string
     */
    private $county;
    /**
     * @var string
     */
    private $country;

    /**
     * AddressMapper constructor.
     *
     * @param string $addr1
     * @param string $town
     * @param string $postcode
     * @param string $county
     * @param string $country
     */
    public function __construct(string $addr1, string $town, string $postcode, string $county, string $country)
    {
        $this->addr1 = $addr1;
        $this->town = $town;
        $this->postcode = $postcode;
        $this->county = $county;
        $this->country = $country;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
