<?php

namespace App\Presentations\Request;

use App\Presentations\BasePresentationObject;

class AddressPresenter extends BasePresentationObject
{
    protected string $firstName;
    protected string $lastName;
    protected string $street;
    protected string $city;
    protected string $zip;
    protected string $phone;
    protected string $email;
    protected string $country;

    public function __construct(array $address)
    {
        $this->firstName = $address['firstName'];
        $this->lastName = $address['lastName'];
        $this->street = $address['street'];
        $this->city = $address['city'];
        $this->zip = $address['zip'];
        $this->phone = $address['phone'];
        $this->email = $address['email'];
        $this->country = $address['country'];
    }

    /**
     * @return mixed|string
     */
    public function getFirstName(): mixed
    {
        return $this->firstName;
    }

    /**
     * @return mixed|string
     */
    public function getLastName(): mixed
    {
        return $this->lastName;
    }

    /**
     * @return mixed|string
     */
    public function getStreet(): mixed
    {
        return $this->street;
    }

    /**
     * @return mixed|string
     */
    public function getCity(): mixed
    {
        return $this->city;
    }

    /**
     * @return mixed|string
     */
    public function getZip(): mixed
    {
        return $this->zip;
    }

    /**
     * @return mixed|string
     */
    public function getPhone(): mixed
    {
        return $this->phone;
    }

    /**
     * @return mixed|string
     */
    public function getEmail(): mixed
    {
        return $this->email;
    }

    /**
     * @return mixed|string
     */
    public function getCountry(): mixed
    {
        return $this->country;
    }
}
