<?php

namespace App\Presentations\Request;

use App\Presentations\BasePresentationObject;

class PaymentCapturePresenter extends BasePresentationObject
{
    /**
     * Customer ID in the request.
     */
    protected string $id;

    protected string|null $externalId;

    protected TransactionPresenter $transaction;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->externalId = $data['externalId'];

        $this->transaction = new TransactionPresenter(
            $data['transaction']['reference'],
            null,
            $data['transaction']['amount'],
            null,
            [],
        );

        /*if (isset($data['payer'])) {
            $billingAddress = isset($data['payer']['billing']) ? new AddressPresenter($data['payer']['billing']) : null;
            $shippingAddress = isset($data['payer']['shipping']) ? new AddressPresenter($data['payer']['shipping']) : null;

            $this->payer = new PayerPresenter($data['payer'], $billingAddress, $shippingAddress);
        }

        if (isset($data['3DSecure'])) {
            $this->threeDSecure = new ThreeDSecurePresenter($data['3DSecure']);
        }*/
    }

    /**
     * @return mixed|string
     */
    public function getId(): mixed
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getTransaction(): TransactionPresenter
    {
        return $this->transaction;
    }

    /**
     * @return mixed|string|null
     */
    public function getExternalId(): mixed
    {
        return $this->externalId;
    }
}
