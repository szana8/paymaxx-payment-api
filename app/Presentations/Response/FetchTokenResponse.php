<?php

namespace App\Presentations\Response;

use App\Presentations\BasePresentationObject;

class FetchTokenResponse extends BasePresentationObject
{
    protected string $id;

    protected string $status;

    protected string $externalId;

    protected array $originalResponse;

    protected array $details;

    /**
     * @return string
     */
    public function getExternalId(): string
    {
        return $this->externalId;
    }

    /**
     * @param string $externalId
     */
    public function setExternalId(string $externalId): self
    {
        $this->externalId = $externalId;

        return $this;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
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
     */
    public function setOriginalResponse(array $originalResponse): self
    {
        $this->originalResponse = $originalResponse;

        return $this;
    }

    /**
     * @return array
     */
    public function getDetails(): array
    {
        return $this->details;
    }

    /**
     * @param array $details
     */
    public function setDetails(array $details): self
    {
        $this->details = $details;

        return $this;
    }


}
