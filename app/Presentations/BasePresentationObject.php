<?php

namespace App\Presentations;

use JsonSerializable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\JsonEncodingException;

abstract class BasePresentationObject implements Arrayable, Jsonable, JsonSerializable
{
    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }

    /**
     * Convert the model instance to JSON.
     *
     * @param  int  $options
     * @return string
     *
     * @throws JsonEncodingException
     */
    public function toJson($options = 0)
    {
        $json = json_encode($this->jsonSerialize(), $options);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw JsonEncodingException::forModel($this, json_last_error_msg());
        }

        return $json;
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
