<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreateTokenResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->get('id'),
            'paymentUrl' => $this->get('paymentUrl'),
            'originalResponse' => $this->get('originalResponse'),
        ];
    }
}
