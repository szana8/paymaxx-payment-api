<?php

namespace App\Presentations\Request;

use App\Presentations\BasePresentationObject;

class ThreeDSecurePresenter extends BasePresentationObject
{
    protected ThreeDSecureTransactionPresenter $transaction;

    public function __construct(array $data)
    {
        $this->transaction = isset($data['transaction'])
            ? new ThreeDSecureTransactionPresenter(
                $data['transaction']['currency'],
                $data['transaction']['amount']
            )
            : null;
    }

    /**
     * @return ThreeDSecureTransactionPresenter|null
     */
    public function getTransaction(): ?ThreeDSecureTransactionPresenter
    {
        return $this->transaction;
    }


}
