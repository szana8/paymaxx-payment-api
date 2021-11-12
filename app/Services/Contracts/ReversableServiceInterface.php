<?php

namespace App\Services\Contracts;

use App\Presentations\Response\ReversalPaymentResponse;

interface ReversableServiceInterface
{
    public function reversal(): ReversalPaymentResponse;
}
