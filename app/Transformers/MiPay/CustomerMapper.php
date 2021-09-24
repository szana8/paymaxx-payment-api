<?php

namespace App\Transformers\MiPay;

use App\Presentations\Request\PayerPresenter;

class CustomerMapper
{
    /**
     * @var string
     */
    private $customerID;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $msisdn;

    /**
     * @var
     */
    private $billing;

    /**
     * @var
     */
    private $shipping;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var string
     */
    private $lang;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $regDate;

    /**
     * @var string
     */
    private $channel;

    public function __construct(
        PayerPresenter $data,
        AddressMapper $billing,
        AddressMapper $shipping
    ) {
        $this->customerID = $data->getCustomerID();
        $this->firstName = $data->getBilling()->getFirstName();
        $this->lastName = $data->getBilling()->getLastName();
        $this->email = $data->getEmail();
        $this->msisdn = str_replace('+', '', $data->getBilling()->getPhone());
        $this->billing = $billing;
        $this->shipping = $shipping;
        $this->ip = $data->getIp();
        $this->lang = $data->getLang();
        $this->status = $data->getStatus();
        $this->regDate = $data->getDateRegistration();
        $this->channel = $data->getChannel();
    }

    public function toArray(): array
    {
        $output = get_object_vars($this);
        $output['shipping'] = $output['shipping']->toArray();
        $output['billing'] = $output['billing']->toArray();

        $output['regDate'] = $this->regDate->format('Y-m-d\TH:i:sO');

        return $output;
    }
}
