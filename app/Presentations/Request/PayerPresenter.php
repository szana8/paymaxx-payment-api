<?php

namespace App\Presentations\Request;

use App\Presentations\BasePresentationObject;
use Carbon\Carbon;

class PayerPresenter extends BasePresentationObject
{
    protected string $customerID;

    protected string $email;

    protected AddressPresenter $billing;

    protected AddressPresenter $shipping;

    protected string $ip;

    protected string $lang;

    protected string $status;

    protected Carbon $dateRegistration;

    protected string $channel;

    protected string $verificationStatus;

    protected Carbon $dateLastUpdated;

    public function __construct(
        array $data,
        ?AddressPresenter $billing = null,
        ?AddressPresenter $shipping = null
    ) {
        $this->customerID = $data['id'];
        $this->email = $data['email'];

        if ($billing) {
            $this->billing = $billing;
        }

        if ($shipping) {
            $this->shipping = $shipping;
        }

        $this->ip = $data['ipAddress'];
        $this->lang = $data['language'];
        $this->status = $data['status'];
        $this->dateRegistration = new Carbon($data['dateRegistration']);
        $this->verificationStatus = $data['verificationStatus'];
        $this->dateLastUpdated = new Carbon($data['dateLastUpdated']);
        $this->channel = $data['channel'];
    }

    /**
     * @return mixed|string
     */
    public function getCustomerID(): mixed
    {
        return $this->customerID;
    }

    /**
     * @return mixed|string
     */
    public function getEmail(): mixed
    {
        return $this->email;
    }

    /**
     * @return AddressPresenter
     */
    public function getBilling(): AddressPresenter
    {
        return $this->billing;
    }

    /**
     * @return AddressPresenter
     */
    public function getShipping(): AddressPresenter
    {
        return $this->shipping;
    }

    /**
     * @return mixed|string
     */
    public function getIp(): mixed
    {
        return $this->ip;
    }

    /**
     * @return mixed|string
     */
    public function getLang(): mixed
    {
        return $this->lang;
    }

    /**
     * @return mixed|string
     */
    public function getStatus(): mixed
    {
        return $this->status;
    }

    /**
     * @return Carbon
     */
    public function getDateRegistration(): Carbon
    {
        return $this->dateRegistration;
    }

    /**
     * @return mixed|string
     */
    public function getChannel(): mixed
    {
        return $this->channel;
    }

    /**
     * @return mixed|string
     */
    public function getVerificationStatus(): mixed
    {
        return $this->verificationStatus;
    }

    /**
     * @return Carbon
     */
    public function getDateLastUpdated(): Carbon
    {
        return $this->dateLastUpdated;
    }

    /**
     * @param mixed|string $status
     */
    public function setStatus(mixed $status): void
    {
        $this->status = $status;
    }

    /**
     * @param mixed|string $channel
     */
    public function setChannel(mixed $channel): void
    {
        $this->channel = $channel;
    }

}
