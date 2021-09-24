<?php

namespace App\Presentations\Response;

use App\Presentations\BasePresentationObject;

class CancelTokenResponse extends BasePresentationObject
{
    protected string $status;

    protected array $originalResponse;

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return CancelTokenResponse
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return array
     */
    public function getOriginalResponse(): array
    {
        return $this->originalResponse;
    }

    /**
     * @param array $originalResponse
     * @return CancelTokenResponse
     */
    public function setOriginalResponse(array $originalResponse): self
    {
        $this->originalResponse = $originalResponse;

        return $this;
    }
}
