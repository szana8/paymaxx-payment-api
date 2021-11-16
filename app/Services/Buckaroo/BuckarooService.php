<?php

namespace App\Services\Buckaroo;

use App\Presentations\Request\CreatePaymentPresenter;
use App\Transformers\Buckaroo\CreatePaymentRequestTransformer;

abstract class BuckarooService
{
    protected string $guid;

    protected string $key;

    protected string $secret_key;

    protected string $store_name;

    public function authenticate(CreatePaymentPresenter $createPaymentPresenter): string
    {
        $url = config('providers.buckaroo.url');

        return $this->getHmac($createPaymentPresenter, $url);
    }

    public function withCredentials(array $credentials): self
    {
        $this->guid = $credentials['guid'];
        $this->key = $credentials['key'];
        $this->secret_key = $credentials['secret_key'];
        $this->store_name = $credentials['store_name'];

        return $this;
    }

    protected function getHmac(CreatePaymentPresenter $request, string $url): string
    {
        $data = (new CreatePaymentRequestTransformer($request))->transform();
        $method = 'POST';
        $uri = parse_url($url);
        $base64 = base64_encode(md5(json_encode($data), true));
        $key = $this->key;
        $uri = strtolower(urlencode($uri['host'] . $uri['path']));
        $nonce = 'nonce_' . rand(0000000, 9999999);
        $time = time();
        $hmac = $key . strtoupper($method) . $uri . $time . $nonce . $base64;
        $hmac = base64_encode(hash_hmac('sha256', $hmac, $this->secret_key, true));

        return 'hmac ' . $key . ':' . $hmac . ':' . $nonce . ':' . $time;
    }
}
